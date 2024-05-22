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

        Permission::create(['name' => 'dashboard',
                            'description' => 'Ver dashboard'])->syncRoles([$role1, $role2, $role3, $role4]);

        Permission::create(['name' => 'admin.permission.index',
                            'description' => 'Ver lista de permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.permission.create',
                            'description' => 'Crear permiso'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.permission.show',
                            'description' => 'Ver detalle de permiso'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.permission.edit',
                            'description' => 'Modificar permiso'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.permission.destroy',
                            'description' => 'Eliminar permiso'])->syncRoles([$role1]);

                            
        Permission::create(['name' => 'admin.office.index',
                            'description' => 'Ver lista de oficinas'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'admin.office.create',
                            'description' => 'Crear oficina'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.office.show',
                            'description' => 'Ver detalle de oficina'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'admin.office.edit',
                            'description' => 'Modificar oficina'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.office.destroy',
                            'description' => 'Eliminar oficina'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'admin.tdoc.index',
                            'description' => 'Ver lista de tipos de documento'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.tdoc.create',
                            'description' => 'Crear tipo de documento'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.tdoc.show',
                            'description' => 'Ver detalle de tipo de documento'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'admin.tdoc.edit',
                            'description' => 'Modificar tipo de documento'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.tdoc.destroy',
                            'description' => 'Eliminar tipo de documento'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'admin.document.index',
                            'description' => 'Ver lista de documentos'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'admin.document.create',
                            'description' => 'Crear documento'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'admin.document.show',
                            'description' => 'Ver detalle de documento'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'admin.document.edit',
                            'description' => 'Modificar documento'])->syncRoles([$role1, $role2, $role3]);;
        Permission::create(['name' => 'admin.document.destroy',
                            'description' => 'Eliminar documento'])->syncRoles([$role1, $role2]);;

        Permission::create(['name' => 'profile.index',
                            'description' => 'Lista de usuarios'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'profile.edit',
                            'description' => 'Modificar usuario'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'profile.destroy',
                            'description' => 'Eliminar usuario'])->syncRoles([$role1, $role2]);

    }
}
