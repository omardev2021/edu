<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{


    public function path() {
        return $this->belongsTo(Path::class);
    }

    public function topics() {
        return $this->belongsToMany(Topic::class,'courses_topics');
    }

    public function chapters() {
        return $this->hasMany(Chapter::class);
    }

    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmarks');
    }

    public function isBookmarkedBy(User $user): bool
    {
        return $this->bookmarks()->where('user_id', $user->id)->exists();
    }

    public function highlights(): HasMany
    {
        return $this->hasMany(Highlight::class);
    }



}
