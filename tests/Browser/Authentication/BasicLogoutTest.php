<?php

namespace Tests\Browser\Authentication;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lasallesoftware\Library\Authentication\Models\User;

class BasicLogoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('lslibrary:customseed');
    }

    /**
     * Test the basic logout. First, login, then access the logout form in the dropdown
     *
     * @group logout
     */
    public function testBasicLogout()
    {
        echo "\n**Now testing the Tests\Browser\Authentication\BasicLogoutTest class**";

        $user = factory(User::class)->create([
            'email' => 'krugerbloom@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->press('Login')
                ->pause(5000)
                ->visit('/logout')
                ->click('@logout-button')
                ->pause(5000)
                //->assertPathIs('/home')
                ->assertSee('Laravel')
                //->logout()
            ;
        });
    }
}
