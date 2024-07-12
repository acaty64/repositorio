<?php

namespace App\Livewire\Tests;

use Livewire\Component;
use Livewire\WithFileUploads;

class Tests2Index extends Component
{
    use WithFileUploads;

    public $message; 
    public $files = [];
    public $attachs = [];

    public function render()
    {
        return view('livewire.tests.tests2-index');
    }

    public function remove($index)
    {
        unset($this->files[$index]);
    }
    
    public function uploadFiles()
    {
        $this->validate([
            'files.*' =>'file|required|max:1024|mimes:pdf',
            ],
            [
                'files.*.mimes' => 'Solo se permiten archivos PDF.'
            ]
        );
        foreach ($this->files as $file) {
            $file->store('files');
        }
        $this->reset('files');
        $this->js("alert('Archivos grabados exitosamente.')");
        return $this->redirect('/testing', navigate:true);
    }

    public function load($files){
        foreach ($files as $file) {
            $this->message = $file->getClientOriginalName();
            $this->attachs[] = $file;
        }
    }
}