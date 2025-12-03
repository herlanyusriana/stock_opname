<?php

namespace App\Services;

use App\Enums\CountStatus;
use App\Events\CountApproved;
use App\Events\CountChecked;
use App\Events\CountCreated;
use App\Events\CountRejected;
use App\Events\CountVerified;
use App\Models\ActivityLog;
use App\Models\Count;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class CountWorkflowService
{
    public function createCount(User $user, array $payload): Count
    {
        return DB::transaction(function () use ($user, $payload) {
            $count = Count::create([
                'code' => $payload['code'] ?? Str::upper(Str::random(10)),
                'location_id' => $payload['location_id'],
                'user_id' => $user->id,
                'status' => CountStatus::COUNTED,
                'shift' => $payload['shift'],
                'production_date' => $payload['production_date'] ?? null,
                'notes' => $payload['notes'] ?? null,
            ]);

            $this->syncItems($count, $payload['items']);
            $this->logActivity($count, null, CountStatus::COUNTED, 'count_created', $user);

            event(new CountCreated($count));

            return $count->fresh(['items.part', 'location', 'user']);
        });
    }

    public function updateCount(Count $count, User $user, array $payload): Count
    {
        if (!in_array($count->status, [CountStatus::COUNTED, CountStatus::REJECTED], true)) {
            throw new RuntimeException('Count cannot be updated in the current status.');
        }

        return DB::transaction(function () use ($count, $user, $payload) {
            $fromStatus = $count->status;

            $count->update([
                'code' => $payload['code'] ?? $count->code,
                'location_id' => $payload['location_id'] ?? $count->location_id,
                'shift' => $payload['shift'] ?? $count->shift,
                'production_date' => $payload['production_date'] ?? $count->production_date,
                'notes' => $payload['notes'] ?? $count->notes,
                'status' => CountStatus::COUNTED,
                'checked_by' => null,
                'checked_at' => null,
                'verified_by' => null,
                'verified_at' => null,
                'approved_by' => null,
                'approved_at' => null,
                'reject_reason' => null,
            ]);

            $this->syncItems($count, $payload['items']);
            $this->logActivity($count, $fromStatus, CountStatus::COUNTED, 'count_updated', $user);

            event(new CountCreated($count));

            return $count->fresh(['items.part', 'location', 'user']);
        });
    }

    public function checkCount(Count $count, User $user): Count
    {
        if ($count->status !== CountStatus::COUNTED) {
            throw new RuntimeException('Only COUNTED records can be checked.');
        }

        $fromStatus = $count->status;

        $count->update([
            'status' => CountStatus::CHECKED,
            'checked_by' => $user->id,
            'checked_at' => now(),
        ]);

        $this->logActivity($count, $fromStatus, CountStatus::CHECKED, 'count_checked', $user);

        event(new CountChecked($count));

        return $count->fresh();
    }

    public function verifyCount(Count $count, User $user): Count
    {
        if ($count->status !== CountStatus::CHECKED) {
            throw new RuntimeException('Only CHECKED records can be verified.');
        }

        $fromStatus = $count->status;

        $count->update([
            'status' => CountStatus::VERIFIED,
            'verified_by' => $user->id,
            'verified_at' => now(),
        ]);

        $this->logActivity($count, $fromStatus, CountStatus::VERIFIED, 'count_verified', $user);

        event(new CountVerified($count));

        return $count->fresh();
    }

    public function rejectCount(Count $count, User $user, string $reason): Count
    {
        if ($count->status !== CountStatus::CHECKED) {
            throw new RuntimeException('Only CHECKED records can be rejected.');
        }

        $fromStatus = $count->status;

        $count->update([
            'status' => CountStatus::REJECTED,
            'reject_reason' => $reason,
        ]);

        $this->logActivity($count, $fromStatus, CountStatus::REJECTED, 'count_rejected', $user, $reason);

        event(new CountRejected($count, $reason));

        return $count->fresh();
    }

    public function approveCount(Count $count, User $user): Count
    {
        if ($count->status !== CountStatus::VERIFIED) {
            throw new RuntimeException('Only VERIFIED records can be approved.');
        }

        $fromStatus = $count->status;

        $count->update([
            'status' => CountStatus::APPROVED,
            'approved_by' => $user->id,
            'approved_at' => now(),
        ]);

        $this->logActivity($count, $fromStatus, CountStatus::APPROVED, 'count_approved', $user);

        event(new CountApproved($count));

        return $count->fresh();
    }

    protected function syncItems(Count $count, array $items): void
    {
        $count->items()->delete();

        foreach ($items as $item) {
            $count->items()->create([
                'part_id' => $item['part_id'],
                'quantity' => $item['quantity'],
                'production_date' => $item['production_date'] ?? $count->production_date,
                'shift' => $item['shift'] ?? $count->shift,
            ]);
        }
    }

    protected function logActivity(Count $count, ?CountStatus $from, CountStatus $to, string $action, User $user, ?string $reason = null): void
    {
        ActivityLog::create([
            'count_id' => $count->id,
            'user_id' => $user->id,
            'action' => $action,
            'from_status' => $from?->value,
            'to_status' => $to->value,
            'reason' => $reason,
        ]);
    }
}
