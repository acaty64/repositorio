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

    public $request = [];
    public $uploaded_files = [];
    public $message;

    public $q_files = 0;

    public function render()
    {
        return view('livewire.tests-index');
    }

    public function close($key)
    {

        $filename = $this->uploaded_files[$key][0];

        $this->message = 'Eliminando archivo: ' . $filename;
        
        unset($this->uploaded_files[$key]);

        $this->q_files--;

        $this->message = 'Archivo Eliminado: ' . $filename;
    
    }
    public function updatedFiles()
    {
        foreach ($this->files as $value) {
            $this->q_files++;
            $filename = $value->getClientOriginalName();
            $path_tmp = '/livewire/preview-file/';
            $start = strpos($value->temporaryUrl(), $path_tmp) + strlen($path_tmp);
            $lenght = strpos($value->temporaryUrl(),'?') - $start;
            $tmp_file0 = substr($value->temporaryUrl(), $start, $lenght);
            $tmp_file_in = storage_path('app/livewire-tmp/' . $tmp_file0);
            if (env('APP_ENV') === 'testing') {
                $new_name = 'storage/app/public/' . $tmp_file0;
            }else{
                $new_name = 'storage/' . $tmp_file0;
            }
            rename($tmp_file_in, $new_name);
            $this->uploaded_files[] = [$filename, $new_name ];
        }
    }

    public function updatedRequest() {
        $this->files = $this->request['files'];
    }
    
}
