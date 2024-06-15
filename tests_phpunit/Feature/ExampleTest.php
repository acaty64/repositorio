<?php

namespace Tests_phpunit\Feature;

use App\Models\RoleHasPermission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests_phpunit\TestCase;

class ExampleTest extends TestCase
{
    //$this->markTestSkipped('must be revisited.');

    public function test_get_roles_in_role_has_permission_model_return_an_array()
    {
        $roles = RoleHasPermission::getRoles(1);
        $this->assertIsArray($roles);
    }

    public function test_get_permissions_in_role_has_permission_model_return_an_array()
    {
        $permissions = RoleHasPermission::getPermissions(1);
        $this->assertIsArray($permissions);
    }

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(302);
        //$response->assertStatus(200);
    }
}
