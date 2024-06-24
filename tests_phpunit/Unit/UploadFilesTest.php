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
        $this->markTestSkipped('must be revisited.');
        $this->artisan('optimize:clear');

        $local_path = public_path('/testing/pdf/');

        //$path_livewire_tmp = storage_path('app/livewire-tmp');
        //$uploadedFiles[0] = UploadedFile::fake()->create('prueba1.pdf');
        //$uploadedFiles[0]->store($path_livewire_tmp, 'local');
        //$uploadedFiles[1] = UploadedFile::fake()->create('prueba2.pdf');
        
        Storage::fake('local');

        Livewire::test(TestsIndex::class)
            ->set('files', [UploadedFile::fake()->create('prueba1.pdf', 256),
                            UploadedFile::fake()->create('prueba2.pdf', 256)]);
        //->set('files', [$uploadedFiles[0]]);
        //->set('request', ['name'=>'files', 'files'=>$uploadedFiles]);

    }
}
