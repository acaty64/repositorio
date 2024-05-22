<?php

namespace Tests\Feature\Permission;

use App\Livewire\PermissionIndex;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class LivewirePermissionTest extends TestCase
{
    use DatabaseTransactions;

    public function test_permission_index_page_contains_livewire_component()
    {
        $master = User::find(1);
        $this->actingAs($master);
        Livewire::test(PermissionIndex::class)
            ->assertSeeHtml('Nombre')
            ->assertSeeHtml('Permiso')
            ->assertSeeHtml('Descripción')
            ;

    }

    public function test_master_can_add_permission_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);

        Livewire::test(PermissionIndex::class)
            ->set('status', 'create')
            ->assertSeeHtml('Nuevo Permiso');

        $data = [
            'guard_name' => 'NEW',
            'name' => 'Nuevo Permiso',
            'description' => 'Nueva Descripción'
        ];

        $this->actingAs($master);
        Livewire::test(PermissionIndex::class)
            ->call('setStatus', 'create')
            ->set('guard_name', $data['guard_name'])
            ->set('name', $data['name'])
            ->set('description', $data['description'])
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseHas('permissions', $data);

    }

    public function test_master_can_update_permission_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);

        $data = [
            'guard_name' => 'OFF',
            'name' => 'Permiso Test',
            'description' => 'Description test',
        ];
        
        $permission = Permission::create($data);
        $this->assertDatabaseHas('permissions', $data);
        
        $newData = [
            'guard_name' => 'NEW',
            'name' => 'Nuevo Permiso',
            'description' => 'Nueva Descripción',
        ];

        Livewire::actingAs($master)
            ->test(PermissionIndex::class)
            ->set('status', 'edit')
            ->assertSeeHtml('Edición de Permiso');

        Livewire::actingAs($master)
            ->test(PermissionIndex::class)
            ->call('setStatus', 'edit', $permission->id)
            ->assertSet('guard_name', $data['guard_name'])
            ->set('guard_name', $newData['guard_name'])
            ->set('name', $newData['name'])
            ->set('description', $newData['description'])
            ->call('save');

        $this->assertDatabaseHas('permissions', $newData);
        $this->assertDatabaseMissing('permissions', $data);

    }

    public function test_master_can_destroy_a_permission_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);
        $permission = Permission::find(3);

        Livewire::test(PermissionIndex::class)
            ->call('setStatus', 'destroy', $permission->id)
            ->assertSet('permission_id', $permission->id)
            ->assertSeeHtml('Permiso a Eliminar')
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseMissing('permissions', $permission->toArray());

    }

}