<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class TestsIndex extends Component
{
    use WithFileUploads;

    public $files = [];
    public $uploaded_files = [];
    public $message;
    public function render()
    {
        return view('livewire.tests-index');
    }

    public function updatedFiles()
    {
        foreach ($this->files as $value) {
            $this->uploaded_files[] = $value;
        }
    }

}
