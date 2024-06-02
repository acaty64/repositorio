<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'origin', 'office_id', 'filename', 'link', 'display', 'status'];

    protected $append = ['subjects'];

    public function getSubjects()
    {
        return Subject::where('document_id', $this->id)->get();
    }
}
