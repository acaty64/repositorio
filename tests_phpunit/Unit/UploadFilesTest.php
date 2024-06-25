<?php

namespace Tests_phpunit\Unit;

use App\Livewire\TestsIndex;
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

        Livewire::test(TestsIndex::class)
            ->set('files', [$file1, $file2])
            ->assertSet('uploaded_files.0.0', 'prueba1.pdf')
            ->assertSet('uploaded_files.1.0', 'prueba2.pdf')
            ;
        
        $this->markTestSkipped('Falta eliminar los archivos pdf creados.');
        //Storage::disk('public')->delete('storage/'.$ARCHIVO_A_ELIMINAR);
        
    }
}
