<?php

namespace App\Livewire;

use App\Models\Attach;
use App\Models\Document;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\PdfToImage\Pdf;

class xxTestsIndex extends Component
{
    use WithFileUploads;
    use DatabaseTransactions;

    public $files = [];

    public $request = [];
    public $uploaded_files = [];
    public $document_id;
    public $display;
    public $q_files = 0;
    public $message;
    public function render()
    {
        return view('livewire.tests.tests-index');
    }

    public function close($key)
    {

        $filename = $this->uploaded_files[$key][0];

        $this->message = 'Eliminando archivo: ' . $filename;
        $this->destroy_file($key);

        unset($this->uploaded_files[$key]);
        $this->q_files--;
        $this->message = 'Archivo Eliminado: ' . $filename;
    
    }
    public function updatedFiles()
    {
        $this->message = "";
        foreach ($this->files as $value) {
            $this->q_files++;
            $filename = $value->getClientOriginalName();
            $path_tmp = '/livewire/preview-file/';
            $start = strpos($value->temporaryUrl(), $path_tmp) + strlen($path_tmp);
            $lenght = strpos($value->temporaryUrl(),'?') - $start;
            $tmp_file0 = substr($value->temporaryUrl(), $start, $lenght);
            $tmp_file_in = storage_path('app/livewire-tmp/' . $tmp_file0);
            if (env('APP_ENV') === 'testing') {
                $new_name = 'storage/app/public/tests/' . $tmp_file0;
            }else{
                $new_name = 'storage/' . $tmp_file0;
            }
            rename($tmp_file_in, $new_name);
            $this->uploaded_files[] = [$filename, $new_name ];
        }
    }

    public function destroy_files() {
        foreach ($this->uploaded_files as $key => $file) {
            $this->destroy_file($key);
        }
    }
    public function destroy_file($id) {
        $file = $this->uploaded_files[$id];
        $path_tmp = '/public/';
        $start = strpos($file[1], $path_tmp) + strlen($path_tmp);
        $tmp_file0 = substr($file[1], $start);

        if(!Storage::disk('public')->exists($tmp_file0))
        {
            dd('Error no existe: ' . $tmp_file0);
        };
        Storage::disk('public')->delete($tmp_file0);

    }

    public function save_attach() {
        foreach ($this->uploaded_files as $key => $file) {

            $file = $this->uploaded_files[$key];
            $path_tmp = '/public/';
            $start = strpos($file[1], $path_tmp) + strlen($path_tmp);
            $tmp_file0 = substr($file[1], $start);
    
            if(!Storage::disk('public')->exists($tmp_file0))
            {
                dd('Error no existe: ' . $tmp_file0);
            };

            $attach = [
                'attachable_type' => Document::class ,
                'attachable_id' => $this->document_id ,
                'filename' => $file[0] ,
                'link' => $file[1] ,
                'display' => $this->display ,
            ];

            Attach::create( $attach );

        } 
    
    }


    
}
