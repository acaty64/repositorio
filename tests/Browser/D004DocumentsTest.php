<?php

namespace Tests\Browser;

use App\Models\Attach;
use App\Models\Document;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class D004DocumentsTest extends DuskTestCase
{
    //use DatabaseTransactions;
    use DatabaseMigrations;
    
    public function test_it_can_be_see_a_save_document_registry()
    {
        
        $this->artisan('optimize');
        $this->artisan('db:seed');
        
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

        $this->artisan('optimize');
        $this->artisan('db:seed');
        
        $this->browse(function (Browser $browser) {
            $old_data = [
                'date' => Carbon::yesterday(),
                'origin' => 'Prueba de Institucion externa D004',
                'office_id' => 1,
                'abstract' => 'test_master_user_can_edit_a_document',
                'state' => 'pendiente'
            ];
            $document = Document::create($old_data);
            $id = Document::latest('created_at')->first()->id;
            
            $old_data_attach = [
                'attachable_id' => $id,
                'attachable_type' => Document::class,
                'filename' => 'archivo.pdf D004',
                'link' => 'ruta_archivo_servidor',
                'display' => 'private',
            ];
            
            $attach = Attach::create($old_data_attach);
            
            $this->assertDatabaseHas('documents', $old_data);
            $this->assertDatabaseHas('attaches', $old_data_attach);
            
            $new_data = [
                'date' => Carbon::now()->format('Y-m-d'),
                'origin' => 'Nueva Institucion externa',
                'office_id' => 2,
                'abstract' => 'Resumen del documento 2',
                'state' => 'atendido'
            ];
            
            $new_data_attach = [
                'attachable_id' => $old_data_attach['attachable_id'],
                'attachable_type' => $old_data_attach['attachable_type'],
                'filename' => 'archivo2.pdf',
                'link' => 'ruta_archivo_servidor2',
                'display' => 'public',
            ];
            
            $this->artisan('optimize');
            
            $fecha = Carbon::now()->format('d/m/Y');
            $fecha_ = Carbon::now()->format('d-m-Y');
            
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
                ->assertSee($old_data['state'])
                //->assertSee($old_data_attach['filename'])
                //->assertSee($old_data_attach['link'])
                //->assertSee($old_data_attach['display'])
                ->click("#btnEdit".$document->id) 
                ->waitForText("Edición de Documento Id: " . $document->id )
                ->type('#date',$fecha)
                ->type('#origin', $new_data['origin'])
                ->type('#office_id', $new_data['office_id'])
                ->type('#abstract', $new_data['abstract'])
                ->type('#filename', $new_data_attach['filename'])
                ->type('#link', $new_data_attach['link'])
                ->type('#display', $new_data_attach['display'])
                ->type('#state', $new_data['state'])
                ->click("#btn-save")
                ->waitForText('Lista de Documentos')
                ->assertSee($fecha_)
                ->assertSee($new_data['origin'])
                ->assertSee($new_data['office_id'])
                ->assertSee($new_data['abstract'])
                ->assertSee($new_data['state'])
                //->assertSee($new_data_attach['filename'])
                //->assertSee($new_data_attach['link'])
                //->assertSee($new_data_attach['display'])
                ->assertSee('Registro actualizado exitosamente.')
                ;
                
            $this->artisan('optimize');

            $this->assertDatabaseMissing('documents', $old_data);
            $this->assertDatabaseMissing('attaches', $old_data_attach);
            $this->assertDatabaseHas('documents', $new_data);
            $this->assertDatabaseHas('attaches', $new_data_attach);
        });
    }

    public function test_master_user_can_destroy_a_document(): void
    {

        $this->artisan('optimize');
        $this->artisan('db:seed');
        
        $this->browse(function (Browser $browser) {
        $old_data = [
            'date' => Carbon::tomorrow(),
            'origin' => 'Prueba de Institucion externa',
            'office_id' => 1,
            'abstract' => 'test_master_user_can_edit_a_document',
            'state' => 'pendiente'
        ];
        
        $document = Document::create($old_data);
        $id = Document::latest('created_at')->first()->id;

        $old_data_attach = [
            'attachable_id' => $id,
            'attachable_type' => Document::class,
            'filename' => 'archivo.pdf',
            'link' => 'ruta_archivo_servidor',
            'display' => 'private',
        ];
        
        $attach = Attach::create($old_data_attach);

        $this->assertDatabaseHas('documents', $old_data);
        $this->assertDatabaseHas('attaches', $old_data_attach);
        
        $new_data = [
            'date' => Carbon::now(),
            'origin' => 'Nueva Institucion externa',
            'office_id' => 2,
            'abstract' => 'Resumen del documento 2',
            'state' => 'atendido'
        ];

        $new_data_attach = [
            'attachable_id' => $old_data_attach['attachable_id'],
            'attachable_type' => $old_data_attach['attachable_type'],
            'filename' => 'archivo2.pdf',
            'link' => 'ruta_archivo_servidor2',
            'display' => 'public',
        ];

        $this->artisan('optimize');
        
        $fecha = Carbon::now()->format('d/m/Y');

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
                ->assertSee($old_data['state'])
                //->assertSee($old_data_attach['filename'])
                //->assertSee($old_data_attach['link'])
                //->assertSee($old_data_attach['display'])
                ->click("#btnEdit".$document->id) 
                ->waitForText("Edición de Documento Id: " . $document->id )
                ->type('#date',$fecha)
                ->type('#origin', $new_data['origin'])
                ->type('#office_id', $new_data['office_id'])
                ->type('#abstract', $new_data['abstract'])
                ->type('#filename', $new_data_attach['filename'])
                ->type('#link', $new_data_attach['link'])
                ->type('#display', $new_data_attach['display'])
                ->type('#state', $new_data['state'])
                ->click("#btn-save")
                ->waitForText('Lista de Documentos')
                ->assertSee($new_data['date'])
                ->assertSee($new_data['origin'])
                ->assertSee($new_data['office_id'])
                ->assertSee($new_data['abstract'])
                ->assertSee($new_data['state'])
                //->assertSee($new_data_attach['filename'])
                //->assertSee($new_data_attach['link'])
                //->assertSee($new_data_attach['display'])
                ->assertSee('Registro actualizado exitosamente.')
                ;
        });
    }
    
}
