<?php

namespace App\Http\Controllers;

use App\Enums\CountStatus;
use App\Http\Requests\RejectCountRequest;
use App\Http\Requests\StoreCountRequest;
use App\Http\Requests\UpdateCountRequest;
use App\Models\Count;
use App\Models\Location;
use App\Models\Part;
use App\Services\CountWorkflowService;
use Illuminate\Http\Request;

class CountController extends Controller
{
    public function __construct(private CountWorkflowService $workflow)
    {
        $this->authorizeResource(Count::class, 'count');
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $viewMode = $request->get('view', 'review');
        $query = Count::with(['location', 'user', 'items'])->latest();

        // Handle viewMode first for all users
        if ($viewMode === 'my') {
            // Show all counts created by the user regardless of status
            $query->where('user_id', $user->id);
        } elseif ($user->isKeeper()) {
            // Keepers only see their own counts
            $query->where('user_id', $user->id);
        } elseif ($user->isAuditor()) {
            // Auditors see CHECKED status in review mode
            $query->where('status', CountStatus::CHECKED);
        } elseif ($user->isSupervisor()) {
            // Supervisors see VERIFIED status in approval mode
            $query->where('status', CountStatus::VERIFIED);
        } else {
            // Other users: filter by viewMode
            if ($viewMode === 'approval') {
                $query->where('status', CountStatus::VERIFIED);
            } else {
                // Default to review mode (CHECKED status)
                $query->where('status', CountStatus::CHECKED);
            }
        }

        $counts = $query->paginate();

        return view('counts.index', [
            'counts' => $counts,
            'viewMode' => $viewMode,
        ]);
    }

    public function create()
    {
        $locations = Location::orderBy('name')->get();
        $parts = Part::orderBy('name')->get();

        return view('counts.create', compact('locations', 'parts'));
    }

    public function store(StoreCountRequest $request)
    {
        $count = $this->workflow->createCount($request->user(), $request->validated());

        return redirect()->route('counts.show', $count);
    }

    public function show(Count $count)
    {
        $count->load(['location', 'user', 'items.part', 'activityLogs.user']);

        return view('counts.show', compact('count'));
    }

    public function edit(Count $count)
    {
        $locations = Location::orderBy('name')->get();
        $parts = Part::orderBy('name')->get();

        return view('counts.edit', compact('count', 'locations', 'parts'));
    }

    public function update(UpdateCountRequest $request, Count $count)
    {
        $count = $this->workflow->updateCount($count, $request->user(), $request->validated());

        return redirect()->route('counts.show', $count);
    }

    public function destroy(Count $count)
    {
        $count->delete();

        return redirect()->route('counts.index');
    }

    public function check(Request $request, Count $count)
    {
        $this->authorize('check', $count);

        $count = $this->workflow->checkCount($count, $request->user());

        return redirect()->route('counts.show', $count);
    }

    public function verify(Request $request, Count $count)
    {
        $this->authorize('verify', $count);

        $count = $this->workflow->verifyCount($count, $request->user());

        return redirect()->route('counts.show', $count);
    }

    public function reject(RejectCountRequest $request, Count $count)
    {
        $this->authorize('reject', $count);

        $count = $this->workflow->rejectCount($count, $request->user(), $request->validated()['reason']);

        return redirect()->route('counts.show', $count);
    }

    public function approve(Request $request, Count $count)
    {
        $this->authorize('approve', $count);

        $count = $this->workflow->approveCount($count, $request->user());

        return redirect()->route('counts.show', $count);
    }
}
