<?php

namespace Tests_phpunit\Unit;

use App\Livewire\TestsIndex;
use App\Models\Attach;
use App\Models\Document;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests_phpunit\TestCase;

class UploadFilesTest extends TestCase
{
    public function test_upload_files_in_livewire(): void
    {
        //$this->markTestSkipped('must be revisited.');
        $this->artisan('optimize:clear');

        $local_path = public_path('/testing/pdf/');

        Storage::fake('local');
        $file1 = UploadedFile::fake()->create('prueba1.pdf', 256);
        $file2 = UploadedFile::fake()->create('prueba2.pdf', 256);

        $attach = [
            'attachable_id' => 999,
            'display' => 'public'
        ];

        Livewire::test(TestsIndex::class)
            ->set('files', [$file1, $file2])
            ->assertSet('uploaded_files.0.0', 'prueba1.pdf')
            ->assertSet('uploaded_files.1.0', 'prueba2.pdf')
            ->set('document_id', $attach['attachable_id'])
            ->set('display', $attach['display'])
            ->call('save_attach')
            ;
        
        $this->assertDatabaseHas('attaches', $attach);

        $attaches = Attach::all();
        $uploaded_files = [];

        foreach ($attaches as $attach) {
            $path_tmp = '/public/';
            $start = strpos($attach->link, $path_tmp) + strlen($path_tmp);
            $tmp_file0 = substr($attach->link, $start);
            $this->assertTrue(Storage::disk('public')->exists($tmp_file0));
            $uploaded_files[] = ["", $attach->link];
        }

        Livewire::test(TestsIndex::class)
            ->set('uploaded_files', $uploaded_files)
            ->call('destroy_files');
    
        // Limpia los archivos de livewire-tmp
        \Illuminate\Support\Facades\File::cleanDirectory(\storage_path('app/livewire-tmp'));
    
    }

}
