<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $fillable = ['document_id', 'office_id', 'user_id', 'task_id', 'order','state', 'expiry'];
    
}
