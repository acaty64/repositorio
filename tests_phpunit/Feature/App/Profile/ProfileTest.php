<?php

namespace tests_phpunit\Feature\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests_phpunit\TestCase;

class ProfileTest extends TestCase
{
    use DatabaseTransactions;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Master');

        $response = $this
            ->actingAs($user)
            ->get(route('profile.edit', $user->id));

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Master');
        
        $other_user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/admin/profile', [
                'id' => $other_user->id,
                'name' => 'Test User',
                'email' => 'test1@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('profile.index'));

        $other_user->refresh();

        $this->assertSame('Test User', $other_user->name);
        $this->assertSame('test1@example.com', $other_user->email);
        //$this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Master');
        
        $other_user = User::factory()->create();
        
        $response = $this
            ->actingAs($user)
            ->patch('/admin/profile', [
                'id' => $other_user->id,
                'name' => 'Test User',
                'email' => $other_user->email,
            ]);
            
            $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('profile.index'));
            
            $this->assertNotNull($other_user->refresh()->email_verified_at);
        }
        
        public function test_user_can_delete_their_account(): void
        {
            $user = User::factory()->create();
            $user->assignRole('Master');
            
            $other_user = User::factory()->create();
            
            $response = $this
                ->actingAs($user)
                ->delete('/admin/profile', [
                    'id' => $other_user->id,
                ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        //$this->assertGuest();
        $this->assertNull($other_user->fresh());
    }

}
