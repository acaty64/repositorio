<?php

namespace Tests\Feature\Permission;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    // use DatabaseTransactions;
    
    public function test_a_master_user_can_view_dashboard_view(): void
    {
        //$user = User::FindOrFail(1);
        $user = User::factory()->create();
        $user->assignRole('master');

        $response = $this
            ->actingAs($user)
            ->get(route('admin.index'));

        $response->assertStatus(200);
    }
}