<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Course $course): bool
    {
        return $user->status === 'joined' || $course->type === 'public';
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Course $course): bool
    {
    }

    public function delete(User $user, Course $course): bool
    {
    }

    public function restore(User $user, Course $course): bool
    {
    }

    public function forceDelete(User $user, Course $course): bool
    {
    }
}
