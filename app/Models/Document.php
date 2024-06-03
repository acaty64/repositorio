<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'origin', 'office_id', 'abstract', 'filename', 'link', 'display', 'state'];

    protected $append = ['getSubjects', 'getOffice'];

    public function getSubjects()
    {
        return Subject::where('document_id', $this->id)->get();
    }

    public function getOffice()
    {
        return Office::find($this->office_id);
    }


}
