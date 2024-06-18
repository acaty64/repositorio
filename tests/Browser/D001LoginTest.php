<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class D001LoginTest extends DuskTestCase
{
    //use DatabaseTransactions;
    use DatabaseMigrations;

    public function test_registered_users_can_login(): void
    {
        $this->artisan('config:clear');
        $this->artisan('view:clear');
        $this->artisan('db:seed');

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'master@example.com')
                    ->type('password', 'password')
                    ->press('Log in')
                    ->assertAuthenticated();
        });
    }
}
