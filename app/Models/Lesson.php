<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SlideCompletion;

class Lesson extends Model
{

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function objectives(): HasMany
    {
        return $this->hasMany(Objective::class);
    }

    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class);
    }


    public function completedBy()
    {
        return $this->belongsToMany(User::class, 'completed_lessons');
    }

    public function terms(): HasMany
    {
        return $this->hasMany(Term::class);
    }


}
