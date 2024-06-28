<?php

namespace App\Livewire\Documents;

use App\Models\Attach;
use App\Models\Document;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class DocumentIndex extends Component
{
    public $uploaded_files;
    public function render()
    {
        return view('livewire.documents.document-index', [
            'documents' => Document::orderBy('id', 'DESC')->paginate(5)
        ]);
    }

}