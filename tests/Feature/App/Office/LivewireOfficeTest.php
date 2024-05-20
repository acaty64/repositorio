<?php

namespace Tests\Feature\Office;

use App\Livewire\OfficeIndex;
use App\Models\Office;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireOfficeTest extends TestCase
{
    use DatabaseTransactions;

    public function test_office_index_page_contains_livewire_component()
    {
        $master = User::find(1);
        $this->actingAs($master);
        Livewire::test(OfficeIndex::class)
            ->assertSeeHtml('Nombre')
            ->assertSeeHtml('Abreviatura')
            ->assertSeeHtml('Nivel')
            ;

    }

    public function test_master_can_add_office_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);

        Livewire::test(OfficeIndex::class)
            ->set('status', 'create')
            ->assertSeeHtml('Nueva Oficina');

        $data = [
            'abbrev' => 'NEW',
            'name' => 'Nueva Oficina',
            'level' => 1
        ];

        $this->actingAs($master);
        Livewire::test(OfficeIndex::class)
            ->call('setStatus', 'create')
            ->set('abbrev', $data['abbrev'])
            ->set('name', $data['name'])
            ->set('level', $data['level'])
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseHas('offices', $data);

    }

    public function test_master_can_update_office_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);

        $data = [
            'abbrev' => 'OFF',
            'name' => 'Oficina Test',
            'level' => 1,
        ];
        
        $office = Office::create($data);
        $this->assertDatabaseHas('offices', $data);
        
        $newData = [
            'abbrev' => 'NEW',
            'name' => 'Nueva Oficina',
            'level' => 2,
        ];

        Livewire::actingAs($master)
            ->test(OfficeIndex::class)
            ->set('status', 'edit')
            ->assertSeeHtml('Edición de Oficina');

        Livewire::actingAs($master)
            ->test(OfficeIndex::class)
            ->call('setStatus', 'edit', $office->id)
            ->assertSet('abbrev', $data['abbrev'])
            ->set('abbrev', $newData['abbrev'])
            ->set('name', $newData['name'])
            ->set('level', $newData['level'])
            ->call('save');

        $this->assertDatabaseHas('offices', $newData);
        $this->assertDatabaseMissing('offices', $data);

    }

    public function test_master_can_destroy_a_office_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);
        $office = Office::find(3);

        Livewire::test(OfficeIndex::class)
            ->call('setStatus', 'destroy', $office->id)
            ->assertSet('office_id', $office->id)
            ->assertSeeHtml('Oficina a Eliminar')
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseMissing('offices', $office->toArray());

    }

}