<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $guarded = [];

    public function courses() {
        return $this->belongsToMany(Course::class,'courses_topics');
    }
}
