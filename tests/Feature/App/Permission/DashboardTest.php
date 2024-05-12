<?php

namespace Tests\Feature\App\Permission;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use DatabaseTransactions;

    public function test_master_can_see_theirs_options_in_dashboard_view(): void
    {   
        $user1 = User::factory()->create();
        $user1->assignRole('master');
        
        $response = $this
            ->actingAs($user1)
            ->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.index');
        $response->assertSeeText('Usuarios');
        $response->assertSeeText('Accesos');
        $response->assertSeeText('Oficinas');
        $response->assertSeeText('Documentos');
    }
    
    public function test_admin_can_see_theirs_options_in_dashboard_view(): void
    {   
        $user1 = User::factory()->create();
        $user1->assignRole('administrador');
        
        $response = $this
            ->actingAs($user1)
            ->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.index');
        $response->assertSeeText('Usuarios');
        $response->assertSeeText('Accesos');
        $response->assertSeeText('Oficinas');
        $response->assertSeeText('Documentos');
    }
    
    public function test_coordinador_can_see_theirs_options_in_dashboard_view(): void
    {   
        $user1 = User::factory()->create();
        $user1->assignRole('coordinador');
        
        $response = $this
            ->actingAs($user1)
            ->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.index');
        $response->assertDontSeeText('Usuarios');
        $response->assertSeeText('Accesos');
        $response->assertSeeText('Oficinas');
        $response->assertSeeText('Documentos');
    }    

}