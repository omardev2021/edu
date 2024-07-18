<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Path extends Model
{

    public function courses() {
        return $this->hasMany(Course::class);
    }


    public function progressFor(User $user)
    {
        $totalLessons = $this->courses->reduce(function ($carry, $course) {
            return $carry + $course->lessons()->count();
        }, 0);

        $completedLessons = $this->courses->reduce(function ($carry, $course) use ($user) {
            return $carry + $user->completedLessons()->whereIn('id', $course->lessons()->pluck('lessons.id'))->count();
        }, 0);

        return $totalLessons ? ($completedLessons / $totalLessons) * 100 : 0;
    }
}
