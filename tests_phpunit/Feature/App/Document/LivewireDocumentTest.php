<?php

namespace tests_phpunit\Feature\Document;

use App\Livewire\DocumentIndex;
use App\Models\Attach;
use App\Models\Document;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests_phpunit\TestCase;

class LivewireDocumentTest extends TestCase
{
    use DatabaseTransactions;
    
    public function test_document_index_page_contains_livewire_component()
    {
        $master = User::find(1);
        $this->actingAs($master);
        Livewire::test(DocumentIndex::class)
        ->assertSeeHtml('Id')
        ->assertSeeHtml('Fecha')
        ->assertSeeHtml('Origen')
        ->assertSeeHtml('Oficina de Origen')
        ->assertSeeHtml('Documento')
        ->assertSeeHtml('Enlace')
        ->assertSeeHtml('Exposición')
        ->assertSeeHtml('Status')
        ;
        
    }
    
    public function test_master_can_add_document_without_target_registry()
    {
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

        $data_attach = [
            'attachable_type' => Document::class,
            'filename' => 'archivo.pdf',
            'link' => 'ruta_archivo_servidor',
            'display' => 'private',
        ];

        $this->actingAs($master);
        Livewire::test(DocumentIndex::class)
            ->call('setStatus', 'create')
            ->set('date', $data['date'])
            ->set('origin', $data['origin'])
            ->set('office_id', $data['office_id'])
            ->set('abstract', $data['abstract'])
            ->set('state', $data['state'])
            ->set('filename', $data_attach['filename'])
            ->set('link', $data_attach['link'])
            ->set('display', $data_attach['display'])
            ->call('save')
            ->assertSeeHtml('Registro creado exitosamente.');

        $this->assertDatabaseHas('documents', $data);
        $this->assertDatabaseHas('attaches', $data_attach);
        
    }
    
    public function test_master_can_update_document_without_target_registry()
    {
        
        $this->markTestSkipped('must be revisited.');

        $master = User::find(1);
        $this->actingAs($master);
        
        $data = [
            'date' => Carbon::now(),
            'origin' => 'Institucion externa',
            'office_id' => 1,
            'abstract' => 'Resumen del documento',
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
        ->set('date', $newData['date'])
        ->set('origin', $newData['origin'])
        ->set('abstract', $newData['abstract'])
        ->set('office_id', $newData['office_id'])
        ->set('filename', $newData_attach['filename'])
        ->call('save')
        ->assertSeeHtml('Registro actualizado exitosamente.');
        
        $this->assertDatabaseHas('documents', $newData);
        $this->assertDatabaseHas('attaches', $newData_attach);
        $this->assertDatabaseMissing('documents', $data);
        $this->assertDatabaseMissing('attaches', $data_attach);
        
    }
    
    public function test_master_can_destroy_a_document_without_target_registry()
    {
        $this->markTestSkipped('must be revisited.');
        
        $master = User::find(1);
        $this->actingAs($master);
        
        $data = [
            'date' => Carbon::now(),
            'origin' => 'Institucion externa',
            'office_id' => 1,
            'abstract' => 'Resumen del documento.',
            'filename' => 'archivo.pdf',
            'link' => 'ruta_archivo_servidor',
            'display' => 'private',
            'state' => 'pendiente'
        ];
        
        $document = Document::create($data);
        $this->assertDatabaseHas('documents', $data);        
        
        Livewire::test(DocumentIndex::class)
        ->call('setStatus', 'destroy', $document->id)
        ->assertSet('document_id', $document->id)
        ->assertSeeHtml('Documento a Eliminar')
        ->call('save')
        ->assertSeeHtml('Registro eliminado exitosamente.');
        
        $this->assertDatabaseMissing('documents', $document->toArray());
        
    }
    
}