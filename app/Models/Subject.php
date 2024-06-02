<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Subject extends Model
{
    use HasFactory;

    public function subjetable(): MorphTo
    {
        return $this->morphTo();
    }
}
