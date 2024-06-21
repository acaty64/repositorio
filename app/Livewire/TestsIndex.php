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
            $tmp_file0 = substr($value->temporaryUrl(), $start, $lenght);
            $tmp_file_in = storage_path('app/livewire-tmp/' . $tmp_file0);
            $new_name = 'storage/' . $tmp_file0 . ".pdf";
            rename($tmp_file_in, $new_name);
            $this->uploaded_files[] = [$filename, $new_name, $tmp_file_in ];
        }
    }
    
}
