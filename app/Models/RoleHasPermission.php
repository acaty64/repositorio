<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
    protected $fillable = ['permission_id', 'role_id'];
    protected $table = 'role_has_permissions' ;

    public static function getRoles($permission_id): array
    {
        $roles = RoleHasPermission::select('role_id')->where('permission_id', $permission_id)->get();
        $aroles = [];
        foreach ($roles as $role) {
            $aroles[] = $role->role_id;
        }
        return $aroles;
    }

    public static function getPermissions($role_id): array
    {
        $permissions = RoleHasPermission::select('permission_id')->where('role_id', $role_id)->get();
        $apermissions = [];
        foreach ($permissions as $permission) {
            $apermissions[] = $permission->permission_id;
        }
        return $apermissions;
    }

}
