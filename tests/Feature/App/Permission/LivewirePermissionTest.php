<?php

namespace Tests\Feature\Permission;

use App\Livewire\PermissionIndex;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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
            ->assertSeeHtml('Ruta de Permiso')
            ->assertSeeHtml('Descripción');
    }

    public function test_master_can_add_permission_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);

        Livewire::test(PermissionIndex::class)
            ->set('status', 'create')
            ->assertSeeHtml('Nuevo Permiso')
            ->assertSeeHtml('Roles');

        $data = [
            'name' => 'Nuevo Permiso',
            'description' => 'Nueva Descripción',
        ];
        $roles  = [1, 2];

        $this->actingAs($master);
        Livewire::test(PermissionIndex::class)
            ->call('setStatus', 'create')
            ->set('name', $data['name'])
            ->set('description', $data['description'])
            ->set('check_roles', $roles)
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');
            
            $this->assertDatabaseHas('permissions', $data);
            foreach ($roles as $item) {
                $role = Role::findOrFail($item); 
                $this->assertTrue($role->hasPermissionTo($data['name']));
            }
    }

    public function test_master_can_update_permission_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);

        $data = [
            'name' => 'Permiso Test',
            'description' => 'Description test',
        ];
        $roles  = [1, 2];
        $aroles = [];
        foreach ($roles as $item) {
            $role = Role::findOrFail($item);
            $aroles[] = $role;
        }

        $permission = Permission::create($data)->syncRoles($aroles);
        $this->assertDatabaseHas('permissions', $data);
        
        $newData = [
            'name' => 'Nuevo Permiso',
            'description' => 'Nueva Descripción',
        ];
        $newRoles  = [1, 2, 3];

        Livewire::actingAs($master)
            ->test(PermissionIndex::class)
            ->set('status', 'edit')
            ->assertSeeHtml('Edición de Permiso');

        Livewire::actingAs($master)
            ->test(PermissionIndex::class)
            ->call('setStatus', 'edit', $permission->id)
            ->assertSet('name', $data['name'])
            ->set('name', $newData['name'])
            ->set('description', $newData['description'])
            ->set('check_roles', $newRoles)
            ->call('save');

        $this->assertDatabaseHas('permissions', $newData);
        $this->assertDatabaseMissing('permissions', $data);

        foreach ($newRoles as $item) {
            $role = Role::findOrFail($item); 
            $this->assertTrue($role->hasPermissionTo($newData['name']));
        }        

    }

    public function test_master_can_destroy_a_permission_registry()
    {
        //$this->todo('Agregar test async roles');
        
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
        $this->assertFalse($master->can($permission['name']));
    }
    
}