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
        $this->artisan('config:clear');
        $this->artisan('view:clear');

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
                'abstract' => 'Resumen del documento de hoy',
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
        $this->artisan('config:clear');
        $this->artisan('view:clear');
    }
}
