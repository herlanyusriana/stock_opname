<?php

namespace App\Http\Controllers;

use App\Enums\CountStatus;
use App\Enums\UserRole;
use App\Http\Requests\RejectCountRequest;
use App\Http\Requests\StoreCountRequest;
use App\Http\Requests\UpdateCountRequest;
use App\Models\Count;
use App\Models\Location;
use App\Models\Part;
use App\Models\User;
use App\Services\CountWorkflowService;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $query = Count::with(['location', 'user', 'auditor', 'items'])->latest();

        if ($user->isAuditor()) {
            // Auditors see only records assigned to them
            $query->where('auditor_id', $user->id)
                ->whereIn('status', [CountStatus::COUNTED, CountStatus::CHECKED, CountStatus::VERIFIED]);
        } elseif ($user->isSupervisor()) {
            // Supervisors see all records for assignment and approval
        } else {
            // Other users: filter by viewMode
            if ($viewMode === 'approval') {
                $query->where('status', CountStatus::VERIFIED);
            } else {
                // Default to review mode (show both fresh submissions and reviewed items)
                $query->whereIn('status', [CountStatus::COUNTED, CountStatus::CHECKED]);
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
        $auditors = User::where('role', UserRole::AUDITOR->value)->orderBy('name')->get();

        return view('counts.create', compact('locations', 'parts', 'auditors'));
    }

    public function store(StoreCountRequest $request)
    {
        $count = $this->workflow->createCount($request->user(), $request->validated());

        return redirect()->route('counts.show', $count);
    }

    public function show(Count $count)
    {
        $count->load(['location', 'user', 'auditor', 'items.part', 'activityLogs.user']);

        return view('counts.show', compact('count'));
    }

    public function edit(Count $count)
    {
        $locations = Location::orderBy('name')->get();
        $parts = Part::orderBy('name')->get();
        $auditors = User::where('role', UserRole::AUDITOR->value)->orderBy('name')->get();

        return view('counts.edit', compact('count', 'locations', 'parts', 'auditors'));
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

    public function assignmentPdf(Count $count)
    {
        $this->authorize('view', $count);
        $count->load(['location', 'auditor']);

        $pdf = Pdf::loadView('counts.assignment_pdf', ['count' => $count]);

        return $pdf->download("assignment-{$count->code}.pdf");
    }
}
