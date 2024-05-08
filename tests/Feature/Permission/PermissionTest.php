<?php

namespace Tests\Feature\Permission;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use DatabaseTransactions;
    
    public function test_authorizated_users_can_view_dashboard_view(): void
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

    public function test_authorizated_users_can_view_office_index_view(): void
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
            ->get(route('admin.office.index'));
        $response->assertStatus(200);

        $response = $this
            ->actingAs($user2)
            ->get(route('admin.office.index'));
        $response->assertStatus(200);

        $response = $this
            ->actingAs($user3)
            ->get(route('admin.office.index'));
        $response->assertStatus(200);

        $response = $this
            ->actingAs($user4)
            ->get(route('admin.office.index'));
        $response->assertStatus(200);
        
    }



}