<?php

namespace App\Policies;

use App\Enums\CountStatus;
use App\Enums\UserRole;
use App\Models\Count;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([UserRole::AUDITOR, UserRole::SPV]);
    }

    public function view(User $user, Count $count): bool
    {
        if ($user->isAuditor()) {
            return true;
        }

        if ($user->isSupervisor()) {
            return in_array($count->status, [CountStatus::VERIFIED, CountStatus::APPROVED], true);
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isAuditor();
    }

    public function update(User $user, Count $count): bool
    {
        return $user->isAuditor()
            && in_array($count->status, [CountStatus::COUNTED, CountStatus::REJECTED], true);
    }

    public function delete(User $user, Count $count): bool
    {
        return $user->isAuditor()
            && $count->status === CountStatus::COUNTED;
    }

    public function check(User $user, Count $count): bool
    {
        return $user->isAuditor()
            && $count->status === CountStatus::COUNTED;
    }

    public function verify(User $user, Count $count): bool
    {
        return $user->isAuditor()
            && $count->status === CountStatus::CHECKED;
    }

    public function reject(User $user, Count $count): bool
    {
        return $user->isAuditor()
            && $count->status === CountStatus::CHECKED;
    }

    public function approve(User $user, Count $count): bool
    {
        return $user->isSupervisor()
            && $count->status === CountStatus::VERIFIED;
    }
}
