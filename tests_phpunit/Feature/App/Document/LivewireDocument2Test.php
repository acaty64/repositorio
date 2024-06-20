<?php

namespace tests_phpunit\Feature\Document;

use App\Livewire\DocumentIndex;
use App\Models\Attach;
use App\Models\Document;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests_phpunit\TestCase;

class LivewireDocument2Test extends TestCase
{
    use DatabaseTransactions;
    
    public function test_master_can_add_document_with_multiple_attach()
    {
        $this->markTestSkipped('must be revisited.');

        $master = User::find(1);
        $this->actingAs($master);
        
        Livewire::test(DocumentIndex::class)
            ->set('status', 'create')
            ->assertSeeHtml('Nuevo Documento');
        
        $data = [
            'date' => Carbon::now(),
            'origin' => 'Institucion externa',
            'office_id' => 1,
            'abstract' => 'Nuevo Resumen del documento.',
            'state' => 'pendiente'
            ];

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
        $data_attach[0] = [
            'attachable_type' => Document::class,
            'filename' => $filename,
            //'link' => $server_file,
            'display' => 'private',
        ];

        $filename = 'prueba2.pdf';
        $local_file = $local_path . $filename;
        $uploadedFiles[1] = new UploadedFile(
            $local_file,
            $filename,
            'application/pdf',
            null,
            true
        );
        $data_attach[1] = [
            'attachable_type' => Document::class,
            'filename' => $filename,
            //'link' => $server_file,
            'display' => 'private',
        ];

        $filename = 'prueba3.pdf';
        $local_file = $local_path . $filename;
        $uploadedFiles[2] = new UploadedFile(
            $local_file,
            $filename,
            'application/pdf',
            null,
            true
        );
        $data_attach[2] = [
            'attachable_type' => Document::class,
            'filename' => $filename,
            //'link' => $server_file,
            'display' => 'private',
        ];
//dd($uploadedFiles);
        $this->actingAs($master);
        Livewire::test(DocumentIndex::class)
            ->call('setStatus', 'create')
            ->set('date', $data['date'])
            ->set('origin', $data['origin'])
            ->set('office_id', $data['office_id'])
            ->set('abstract', $data['abstract'])
            ->set('state', $data['state'])
            ->set('uploadedFiles', $uploadedFiles)
            ->set('display', $data_attach[0]['display'])
            ->call('save')
            ->assertSeeHtml('Registro creado exitosamente.');

        $this->assertDatabaseHas('documents', $data);
        $this->assertDatabaseHas('attaches', $data_attach[0]);
        $this->assertDatabaseHas('attaches', $data_attach[1]);
        $this->assertDatabaseHas('attaches', $data_attach[2]);
        
    }
    
    public function test_master_can_update_document_with_multiple_attach()
    {
        
        $this->markTestSkipped('must be revisited.');

        $master = User::find(1);
        $this->actingAs($master);
        
        $data = [
            'date' => Carbon::now(),
            'origin' => 'Institucion externa 1',
            'office_id' => 1,
            'abstract' => 'Resumen del documento 1',
            'state' => 'pendiente'
        ];

        $document = Document::create($data);

        $data_attach = [
            'attachable_id' => $document->id,
            'attachable_type' => Document::class,
            'filename' => 'archivo.pdf',
            'link' => 'ruta_archivo_servidor',
            'display' => 'private',
        ];
        
        Attach::create($data_attach);

        $this->assertDatabaseHas('documents', $data);
        $this->assertDatabaseHas('attaches', $data_attach);
        
        $newData = [
            'id' => $document->id,
            'date' => Carbon::now(),
            'origin' => 'Nueva Institucion externa',
            'office_id' => 2,
            'abstract' => 'Nuevo Resumen del documento.',
            'state' => 'pendiente'
        ];
        
        $newData_attach = [
            'attachable_type' => Document::class,
            'filename' => 'nuevoarchivo.pdf',
            'link' => 'ruta_archivo_servidor',
            'display' => 'private',
        ];
        
        Livewire::actingAs($master)
        ->test(DocumentIndex::class)
        ->set('status', 'edit')
        ->assertSeeHtml('Edición de Documento');
        
        Livewire::actingAs($master)
        ->test(DocumentIndex::class)
        ->call('setStatus', 'edit', $document->id)
        ->assertSet('origin', $data['origin'])
        ->assertSet('office_id', $data['office_id'])
        ->assertSet('abstract', $data['abstract'])
        ->set('date', $newData['date'])
        ->set('origin', $newData['origin'])
        ->set('abstract', $newData['abstract'])
        ->set('office_id', $newData['office_id'])
        ->set('filename', $newData_attach['filename'])
        ->set('link', $newData_attach['link'])
        ->set('display', $newData_attach['display'])
        ->call('save')
        ->assertSeeHtml('Registro actualizado exitosamente. Id: ' . $document->id)
        ->assertSeeHtml('Lista de Documentos');
        
        $this->assertDatabaseHas('documents', $newData);
        $this->assertDatabaseHas('attaches', $newData_attach);
        $this->assertDatabaseMissing('documents', $data);
        $this->assertDatabaseMissing('attaches', $data_attach);
        
    }
    
    public function test_master_can_destroy_a_document_with_multiple_attach()
    {
        $this->markTestSkipped('must be revisited.');
        
        $master = User::find(1);
        $this->actingAs($master);
        
        $data = [
            'date' => Carbon::now(),
            'origin' => 'Institucion externa',
            'office_id' => 1,
            'abstract' => 'Resumen del documento.',
            'state' => 'pendiente'
        ];

        $document = Document::create($data);

        $data_attach = [
            'attachable_id' => $document->id,
            'attachable_type' => Document::class,
            'filename' => 'archivo.pdf',
            'link' => 'ruta_archivo_servidor',
            'display' => 'private',
        ];
        
        $attach = Attach::create($data_attach);

        $this->assertDatabaseHas('documents', $data);
        $this->assertDatabaseHas('attaches', $data_attach);    
        
        Livewire::test(DocumentIndex::class)
        ->call('setStatus', 'destroy', $document->id)
        ->assertSet('document_id', $document->id)
        ->assertSeeHtml('Documento a Eliminar')
        ->call('save')
        ->assertSeeHtml('Registro eliminado exitosamente. Id: ' . $document->id);
        
        $this->assertDatabaseMissing('documents', $document->toArray());
        $this->assertDatabaseMissing('attaches', $attach->toArray());
        
    }
    
}