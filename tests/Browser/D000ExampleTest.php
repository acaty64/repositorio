<?php

namespace Tests\Browser;

//use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class D000ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     */
    public function testBasicExample(): void
    {
        $this->artisan('config:clear');
        $this->artisan('view:clear');

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Password');
        });
    }
}
