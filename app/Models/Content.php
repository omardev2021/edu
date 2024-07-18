<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Content extends Model
{

    public function slide(): BelongsTo
    {
        return $this->belongsTo(Slide::class);
    }
}
