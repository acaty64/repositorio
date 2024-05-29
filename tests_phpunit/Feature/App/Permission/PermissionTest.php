<?php

namespace Tests_phpunit\Feature\App\Permission;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;
use Tests_phpunit\TestCase;

class PermissionTest extends TestCase
{
    use DatabaseTransactions;

    public function test_non_authenticated_users_can_not_view_dashboard_view(): void
    {    
        $response = $this->get(route('dashboard'));
        $response->assertStatus(302);
        $response->assertRedirectToRoute('login');
    }
    
    public function test_authenticated_users_can_view_dashboard_view(): void
    {
        $user1 = User::factory()->create();
        $user1->assignRole('master');
        $user2 = User::factory()->create();
        $user2->assignRole('administrador');
        $user3 = User::factory()->create();
        $user3->assignRole('coordinador');
        $user4 = User::factory()->create();
        $user4->assignRole('operador');

        $response = $this
            ->actingAs($user1)
            ->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.index');
        $response->assertSee('Panel de Control');

        $response = $this
            ->actingAs($user2)
            ->get(route('dashboard'));
        $response->assertStatus(200);

        $response = $this
            ->actingAs($user3)
            ->get(route('dashboard'));
        $response->assertStatus(200);

        $response = $this
            ->actingAs($user4)
            ->get(route('dashboard'));
        $response->assertStatus(200);
        
    }

}