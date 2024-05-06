<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @return void
     * 
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role1 = Role::create(['name' => 'Master']);
        $role2 = Role::create(['name' => 'Administrador']);
        $role3 = Role::create(['name' => 'Coordinador']);
        $role4 = Role::create(['name' => 'Operador']);

        Permission::create(['name' => 'admin.index',
                            'description' => 'Ver dashboard'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'office.index',
                            'description' => 'Ver lista de oficinas'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'office.create',
                            'description' => 'Crear oficinas'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'office.store',
                            'description' => 'Guardar oficinas'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'office.show',
                            'description' => 'Ver detalle de oficina'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'office.update',
                            'description' => 'Editar oficinas'])->syncRoles([$role1, $role2]);;
        Permission::create(['name' => 'office.destroy',
                            'description' => 'Eliminar oficinas'])->syncRoles([$role1, $role2]);;

        Permission::create(['name' => 'profile.edit',
                            'description' => 'Editar usuario'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'profile.update',
                            'description' => 'Modificar usuario'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'profile.destroy',
                            'description' => 'Eliminar usuario'])->syncRoles([$role1, $role2]);

    }
}
