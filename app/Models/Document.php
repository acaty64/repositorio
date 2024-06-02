<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $append = ['subjects'];

    public function getSubjects()
    {
        return Subject::where('document_id', $this->id)->get();
    }
}
