<?php

namespace Tests_phpunit\Unit;

use App\Livewire\TestsIndex;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests_phpunit\TestCase;

class UploadFilesTest extends TestCase
{
    public function test_upload_files_in_livewire(): void
    {
        $this->markTestSkipped('must be revisited.');
        $local_path = public_path('/testing/pdf/');

        $filename = 'prueba1.pdf';
        $local_file = $local_path . $filename;
        $uploadedFiles[0] = new UploadedFile(
            $local_file,
            $filename,
            'application/pdf',
            null,
            true
        );

        $filename = 'prueba2.pdf';
        $local_file = $local_path . $filename;
        $uploadedFiles[1] = new UploadedFile(
            $local_file,
            $filename,
            'application/pdf',
            null,
            true
        );

        Livewire::test(TestsIndex::class)
        ->set('uploadfiles', $uploadedFiles);

    }
}
