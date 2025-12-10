<?php

namespace App\Http\Controllers\Api;

use App\Enums\CountStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\RejectCountRequest;
use App\Http\Requests\StoreCountRequest;
use App\Http\Requests\UpdateCountRequest;
use App\Models\Count;
use App\Services\CountWorkflowService;
use Illuminate\Http\Request;

class CountApiController extends Controller
{
    public function __construct(private CountWorkflowService $workflow)
    {
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Count::class);
        $user = $request->user();
        $status = $request->query('status');

        $query = Count::with(['location', 'user', 'auditor', 'items.part'])->latest();

        if ($user->isAuditor()) {
            $query->where('auditor_id', $user->id)
                ->whereIn('status', [CountStatus::COUNTED, CountStatus::CHECKED, CountStatus::VERIFIED]);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $counts = $query->paginate();

        return response()->json($counts);
    }

    public function store(StoreCountRequest $request)
    {
        $this->authorize('create', Count::class);
        $count = $this->workflow->createCount($request->user(), $request->validated());

        return response()->json($count->load(['location', 'items.part', 'auditor']), 201);
    }

    public function show(Count $count)
    {
        $this->authorize('view', $count);
        $count->load(['location', 'items.part', 'user']);

        return response()->json($count->load(['auditor']));
    }

    public function update(UpdateCountRequest $request, Count $count)
    {
        $this->authorize('update', $count);
        $count = $this->workflow->updateCount($count, $request->user(), $request->validated());

        return response()->json($count->load(['location', 'items.part', 'auditor']));
    }

    public function check(Request $request, Count $count)
    {
        $this->authorize('check', $count);
        $count = $this->workflow->checkCount($count, $request->user());

        return response()->json($count);
    }

    public function verify(Request $request, Count $count)
    {
        $this->authorize('verify', $count);
        $count = $this->workflow->verifyCount($count, $request->user());

        return response()->json($count);
    }

    public function reject(RejectCountRequest $request, Count $count)
    {
        $this->authorize('reject', $count);
        $count = $this->workflow->rejectCount($count, $request->user(), $request->validated()['reason']);

        return response()->json($count);
    }

    public function approve(Request $request, Count $count)
    {
        $this->authorize('approve', $count);
        $count = $this->workflow->approveCount($count, $request->user());

        return response()->json($count);
    }
}
