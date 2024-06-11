<?php

namespace Tests\Browser;

use App\Models\Document;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class D003DocumentsTest extends DuskTestCase
{
    use DatabaseTransactions;

    public function test_master_user_can_see_documents_index(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/dashboard')
                    ->assertSee('Documentos')
                    ->visit("/admin/document")
                    ->click("#document-index")
                    ->waitForText('Lista de Documentos')
                    ->assertSee('Id')
                    ->assertSee('Fecha')
                    ->assertSee('Origen')
                    ->assertSee('Oficina de Origen')
                    ->assertSee('Resumen')
                    ->assertSee('Exposición')
                    ->assertSee('Estado')
                    ;
        });
    }

    public function test_master_user_can_add_a_document(): void
    {
      
        $this->browse(function (Browser $browser) {
            $data = [
                'date' => Carbon::now(),
                'origin' => 'Institucion externa',
                'office_id' => 1,
                'abstract' => 'Resumen del documento',
                'filename' => 'archivo.pdf',
                'link' => 'ruta_archivo_servidor',
                'display' => 'private',
                'state' => 'pendiente'
            ];

            $fecha = Carbon::now()->format('d/m/Y');

            $browser->loginAs(User::find(1))
                    ->visit('/dashboard')
                    ->assertSee('Documentos')
                    ->visit("/admin/document")
                    ->click("#document-index")
                    ->click("#btn-create")
                    ->waitForText('Nuevo Documento')
                    ->type('#date',$fecha)
                    ->type('#origin', $data['origin'])
                    ->type('#office_id', $data['office_id'])
                    ->type('#abstract', $data['abstract'])
                    ->type('#filename', $data['filename'])
                    ->type('#link', $data['link'])
                    ->type('#display', $data['display'])
                    ->type('#state', $data['state'])
                    ->click("#btn-save")
                    ->waitForText('Lista de Documentos')
                    ->assertSee($data['date'])
                    ->assertSee($data['origin'])
                    ->assertSee($data['office_id'])
                    ->assertSee($data['abstract'])
                    ->assertSee($data['display'])
                    ->assertSee($data['state'])
                    ->assertSee('Registro creado exitosamente.')
                    ;
        });
    }
    
    public function test_master_user_can_edit_a_document(): void
    {
      
        $this->browse(function (Browser $browser) {
            $old_data = [
                'date' => Carbon::now(),
                'origin' => 'Institucion externa',
                'office_id' => 1,
                'abstract' => 'Resumen del documento',
                'filename' => 'archivo.pdf',
                'link' => 'ruta_archivo_servidor',
                'display' => 'private',
                'state' => 'pendiente'
            ];

            $fecha = Carbon::now()->format('d/m/Y');

            $document = Document::create($old_data);
            
            $this->assertDatabaseHas('documents', $old_data);

            $new_data = [
                'date' => Carbon::now(),
                'origin' => 'Nueva Institucion externa',
                'office_id' => 2,
                'abstract' => 'Resumen del documento 2',
                'filename' => 'archivo2.pdf',
                'link' => 'ruta_archivo_servidor2',
                'display' => 'public',
                'state' => 'atendido'
            ];

            $browser->loginAs(User::find(1))
                    ->visit('/dashboard')
                    ->assertSee('Documentos')
                    ->visit("/admin/document")
                    ->click("#document-index")
                    ->waitForText('Lista de Documentos')
                    ->assertSee('Lista de Documentos')
                    ->assertSee($document->id)
                    ->assertSee($old_data['date'])
                    ->assertSee($old_data['origin'])
                    ->assertSee($old_data['office_id'])
                    ->assertSee($old_data['abstract'])
                    ->assertSee($old_data['display'])
                    ->assertSee($old_data['state'])                    
                    ->click("#btnEdit".$document->id) 
                    ->waitForText("Edición de Documento Id: " . $document->id )
                    ->type('#date',$fecha)
                    ->type('#origin', $new_data['origin'])
                    ->type('#office_id', $new_data['office_id'])
                    ->type('#abstract', $new_data['abstract'])
                    ->type('#filename', $new_data['filename'])
                    ->type('#link', $new_data['link'])
                    ->type('#display', $new_data['display'])
                    ->type('#state', $new_data['state'])
                    ->click("#btn-save")
                    ->waitForText('Lista de Documentos')
                    ->assertSee($new_data['date'])
                    ->assertSee($new_data['origin'])
                    ->assertSee($new_data['office_id'])
                    ->assertSee($new_data['abstract'])
                    ->assertSee($new_data['display'])
                    ->assertSee($new_data['state'])
                    ->assertSee('Registro actualizado exitosamente.')
                    ;
        });
    }
}
