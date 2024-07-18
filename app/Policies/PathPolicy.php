<?php

namespace App\Policies;

use App\Models\Path;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Policy;

class PathPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Path $path): bool
    {
        return $user->status === 'joined' || $path->type === 'public';
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Policy $policy): bool
    {
    }

    public function delete(User $user, Policy $policy): bool
    {
    }

    public function restore(User $user, Policy $policy): bool
    {
    }

    public function forceDelete(User $user, Policy $policy): bool
    {
    }
}
