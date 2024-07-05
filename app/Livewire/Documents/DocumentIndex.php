<?php

namespace App\Livewire\Documents;

use App\Models\Document;
use Livewire\Attributes\On;
use Livewire\Component;

class DocumentIndex extends Component
{
    public $status;
    public $document_id;

    public function mount()
    {
        $this->status = $this->status ?? "index";
    }
    public function render()
    {
        return view('livewire.documents.document-index', [
            'documents' => Document::orderBy('id', 'DESC')->paginate(5)
        ]);
    }

    #[On('status')]
    public function status($status)
    {
        $this->status = $status;
    }

    #[On('id')]
    public function document_id($id)
    {
        $this->document_id = $id;
    }

    public function setStatus($status, $document_id=null)
    {
        
        $this->status = $status;
        $this->document_id = $document_id;

        $this->dispatch('status', $status);
        $this->dispatch('document_id', $document_id);
    }
}