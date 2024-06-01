<?php

namespace Tests_phpunit\Feature\App\Permission;

use App\Livewire\RoleIndex;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests_phpunit\TestCase;

class LivewireRoleTest extends TestCase
{
    use DatabaseTransactions;

    public function test_role_index_page_contains_livewire_component()
    {
        $master = User::find(1);
        $this->actingAs($master);
        Livewire::test(RoleIndex::class)
            ->assertSeeHtml('Descripción');
    }

    public function test_master_can_add_role_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);

        Livewire::test(RoleIndex::class)
            ->set('status', 'create')
            ->assertSeeHtml('Nuevo Rol')
            ->assertSeeHtml('Permisos');

        $data = [
            'name' => 'Nuevo Rol',
        ];
        $permisos  = [1, 2];

        $this->actingAs($master);
        Livewire::test(RoleIndex::class)
            ->call('setStatus', 'create')
            ->set('name', $data['name'])
            ->set('check_permissions', $permisos)
            ->set('checks', [])
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');
            
            $this->assertDatabaseHas('roles', $data);
            $role = Role::where('name', $data['name'])->first(); 
            foreach ($permisos as $item) {
                $permiso = Permission::findOrFail($item); 
                $this->assertTrue($role->hasPermissionTo($permiso['name']));
            }
    }

    public function test_master_can_update_role_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);

        $data = [
            'name' => 'Rol Test',
        ];
        $permisos  = [1, 2];
        $apermisos = [];
        foreach ($permisos as $item) {
            $permiso = Permission::findOrFail($item);
            $apermisos[] = $permiso;
        }

        $role = Role::create($data)->syncPermissions($apermisos);
        $this->assertDatabaseHas('roles', $data);
        
        $newData = [
            'name' => 'Nuevo Rol',
        ];
        $newPermisos  = [1, 2, 3];

        Livewire::actingAs($master)
            ->test(RoleIndex::class)
            ->set('status', 'edit')
            ->assertSeeHtml('Edición de Rol');

        Livewire::actingAs($master)
            ->test(RoleIndex::class)
            ->call('setStatus', 'edit', $role->id)
            ->assertSet('name', $data['name'])
            ->set('name', $newData['name'])
            ->set('check_permissions', $newPermisos)
            ->call('save');

        $this->assertDatabaseHas('roles', $newData);
        $this->assertDatabaseMissing('roles', $data);

        $role = Role::where('name', $newData['name'])->first(); 
        foreach ($newPermisos as $item) {
            $permiso = Permission::findOrFail($item); 
            $this->assertTrue($role->hasPermissionTo($permiso->name));
        }        

    }

    public function test_master_can_destroy_a_role_registry()
    {
        
        $master = User::find(1);
        $this->actingAs($master);
        $role = Role::find(3);
        
        Livewire::test(RoleIndex::class)
        ->call('setStatus', 'destroy', $role->id)
        ->assertSet('role_id', $role->id)
        ->assertSeeHtml('Rol a Eliminar')
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');
            
        $this->assertDatabaseMissing('roles', $role->toArray());
        $this->assertFalse($master->can($role['name']));
    }
    
}