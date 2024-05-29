<?php

namespace Tests_phpunit\Feature\App\Office;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;
use Tests_phpunit\TestCase;

class OfficeTest extends TestCase
{
    use DatabaseTransactions;
    
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

    public function test_only_authorizated_users_can_view_office_create_view(): void
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
            ->get(route('admin.office.create'));
        $response->assertStatus(200);

        $response = $this
            ->actingAs($user2)
            ->get(route('admin.office.create'));
        $response->assertStatus(200);

        $response = $this
            ->actingAs($user3)
            ->get(route('admin.office.create'));
        $response->assertStatus(403);

        $response = $this
            ->actingAs($user4)
            ->get(route('admin.office.create'));
        $response->assertStatus(403);
        
    }

}
