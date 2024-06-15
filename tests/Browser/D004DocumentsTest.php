<?php

namespace Tests\Browser;

use App\Models\Document;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class D004DocumentsTest extends DuskTestCase
{
    use DatabaseTransactions;
    
    //$this->markTestSkipped('must be revisited.');
    //$browser->dump();
    public function test_it_can_be_see_a_save_document_registry()
    {
        
        $this->artisan('optimize');
        
        $this->browse(function (Browser $browser) { 
            
            $q_old = Document::count();
            
            $old_data = [
                'date' => Carbon::tomorrow(),
                'origin' => 'Institucion externa - it can be see',
                'office_id' => 1,
                'abstract' => 'test_it_can_be_see_a_save_document_registry',
                'filename' => 'archivo.pdf',
                'link' => 'ruta_archivo_servidor',
                'display' => 'private',
                'state' => 'pendiente'
            ];
            
            $document = Document::create($old_data);
            
            $q_new = Document::count();
            
            $this->assertTrue($q_new == $q_old + 1);
            
            $id = Document::latest('created_at')->first()->id;
            
            $this->artisan('optimize');
            
            $browser->loginAs(User::find(1))
            ->visit('/dashboard')
                ->assertSee('Documentos')
                ->visit("/admin/document")
                ->click("#document-index")
                ->waitForText('Lista de Documentos')
                ->assertSee('Lista de Documentos')
                ;

            $browser->assertSee($id)
                ->assertSee($old_data['date'])
                ->assertSee($old_data['origin'])
                ->assertSee($old_data['office_id'])
                ->assertSee($old_data['abstract'])
                ->assertSee($old_data['state'])  
                ;
        });

    }

    public function test_master_user_can_edit_a_document(): void
    {
        $this->markTestSkipped('must be revisited.');

        $this->artisan('optimize');
        
        $this->browse(function (Browser $browser) {
            $old_data = [
                'date' => Carbon::tomorrow(),
                'origin' => 'Prueba de Institucion externa',
                'office_id' => 1,
                'abstract' => 'test_master_user_can_edit_a_document',
                'filename' => 'archivo.pdf',
                'link' => 'ruta_archivo_servidor',
                'display' => 'private',
                'state' => 'pendiente'
            ];

            $fecha = Carbon::now()->format('d/m/Y');
            
            $document = Document::create($old_data);
            
            $id = Document::latest('created_at')->first()->id;
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

        $this->artisan('optimize');
        
        $browser->loginAs(User::find(1))
                ->visit('/dashboard')
                ->assertSee('Documentos')
                ->visit("/admin/document")
                ->click("#document-index")
                ->waitForText('Lista de Documentos')
                ->assertSee('Lista de Documentos')
                ->assertSee($id)
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
