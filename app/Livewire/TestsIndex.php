<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\PdfToImage\Pdf;

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
            $filename = $value->getClientOriginalName();
            $path_tmp = '/livewire/preview-file/';
            $start = strpos($value->temporaryUrl(), $path_tmp) + strlen($path_tmp);
            $lenght = strpos($value->temporaryUrl(),'?') - $start;
            $tmp_file = substr($value->temporaryUrl(), $start, $lenght);
            $tmp_file = storage_path('app/livewire-tmp') . "/" . $tmp_file;
            $this->uploaded_files[] = [$filename, $tmp_file, $value->temporaryUrl() ];
        }
    }

}
