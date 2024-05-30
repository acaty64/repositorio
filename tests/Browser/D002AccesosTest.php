<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class D002AccesosTest extends DuskTestCase
{
    use DatabaseTransactions;

    public function test_master_user_can_see_access_options(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/dashboard')
                    ->assertSee('Accesos')
                    ->assertDontSee('Usuarios')
                    ->assertDontSee('Permisos')
                    ->assertDontSee('Roles')
                    ->click("i[class='fas fa-angle-left right']")
                    ->waitForText('Usuarios')
                    ->assertSee('Usuarios')
                    ->assertSee('Permisos')
                    ->assertSee('Roles')
                    ->assertSee('Oficinas')
                    ;
        });
    }
    
    public function test_master_user_can_see_users_index(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
            ->visit('/dashboard')
            ->click("i[class='fas fa-angle-left right']")
            ->waitForText('Usuarios')
            ->assertSee('Usuarios')
            ->clickLink('Usuarios')
            ->waitForText('Lista de Usuarios')
            ->assertSee('Lista de Usuarios')
            ;
        });
    }
}
