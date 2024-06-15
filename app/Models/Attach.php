<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attach extends Model
{
    use HasFactory;
    protected $fillable = ['attachable_type', 'attachable_id', 'filename', 'link', 'display'];

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }
}
