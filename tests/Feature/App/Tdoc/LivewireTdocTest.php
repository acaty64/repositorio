<?php

namespace Tests\Feature\Tdoc;

use App\Livewire\TdocIndex;
use App\Models\Tdoc;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireTdocTest extends TestCase
{
    use DatabaseTransactions;

    public function test_tdoc_index_page_contains_livewire_component()
    {
        $master = User::find(1);
        $this->actingAs($master);
        Livewire::test(TdocIndex::class)
            ->assertSeeHtml('Nombre')
            ;

    }

    public function test_master_can_add_tdoc_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);

        Livewire::test(TdocIndex::class)
            ->set('status', 'create')
            ->assertSeeHtml('Nuevo Tipo de Documento');

        $data = [
            'name' => 'Tdoc test',
        ];

        $this->actingAs($master);
        Livewire::test(TdocIndex::class)
            ->call('setStatus', 'create')
            ->set('name', $data['name'])
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseHas('tdocs', $data);

    }

    public function test_master_can_update_tdoc_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);

        $data = [
            'name' => 'Tdoc Test',
        ];
        
        $tdoc = Tdoc::create($data);
        $this->assertDatabaseHas('tdocs', $data);
        
        $newData = [
            'name' => 'Nuevo Tdoc',
        ];

        Livewire::actingAs($master)
            ->test(TdocIndex::class)
            ->set('status', 'edit')
            ->assertSeeHtml('Edición de Tipo de Documento');

        Livewire::actingAs($master)
            ->test(TdocIndex::class)
            ->call('setStatus', 'edit', $tdoc->id)
            ->set('name', $newData['name'])
            ->call('save');

        $this->assertDatabaseHas('tdocs', $newData);
        $this->assertDatabaseMissing('tdocs', $data);

    }

    public function test_master_can_destroy_a_tdoc_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);
        $tdoc = Tdoc::find(3);

        Livewire::test(TdocIndex::class)
            ->call('setStatus', 'destroy', $tdoc->id)
            ->assertSet('tdoc_id', $tdoc->id)
            ->assertSeeHtml('Tipo de documento a Eliminar')
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseMissing('tdocs', $tdoc->toArray());

    }

}