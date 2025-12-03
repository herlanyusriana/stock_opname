<?php

namespace App\Policies;

use App\Models\Part;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartPolicy
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
        return $user->isKeeper() || $user->isAuditor() || $user->isSupervisor();
    }

    public function view(User $user, Part $part): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Part $part): bool
    {
        return false;
    }

    public function delete(User $user, Part $part): bool
    {
        return false;
    }
}
