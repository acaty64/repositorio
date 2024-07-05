<?php

namespace App\Livewire\Documents\Components;

use App\Models\Document;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    #[Modelable]
    public $status;
    public $document_id;
    
    public function render()
    {
        return view('livewire.documents.components.index', [
            'documents' => Document::orderBy('id', 'DESC')->paginate(5)
        ]);
    }

    public function setStatus($status, $id = null )
    {
        $this->status = $status;
        $this->document_id = $id;
    }

}