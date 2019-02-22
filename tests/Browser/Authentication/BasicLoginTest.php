<?php

namespace Tests\Browser\Authentication;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lasallesoftware\Library\Authentication\Models\Personbydomain;

class BasicLoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $personTryingToLogin;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('lslibrary:customseed');

        $this->personTryingToLogin = [
            'email'    => 'bob.bloom@lasallesoftware.ca',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        ];
    }

    /**
     * Test the basic login.
     *
     * @group login
     */
    public function testBasicLogin()
    {
        echo "\n**Now testing the Tests\Browser\Authentication\BasicLoginTest class**";

        $personTryingToLogin = $this->personTryingToLogin;

        $this->browse(function (Browser $browser) use ($personTryingToLogin) {
            $browser->visit('/login')
                ->type('email',    $personTryingToLogin['email'])
                ->type('password', $personTryingToLogin['password'])
                ->press('Login')
                ->pause(5000)
                //->assertPathIs('/home')
                ->assertSee('You are logged in!')
                ->logout();
        });
    }

    /**
     * Test the basic login when the email is incorrect
     *
     * @group login
     */
    public function testLoginEmailFailure() {

        $personTryingToLogin = $this->personTryingToLogin;

        $this->browse(function (Browser $browser) use ($personTryingToLogin) {
            $browser->visit('/login')
                ->type('email', 'wrong@email.com')
                ->type('password', $personTryingToLogin['password'])
                ->press('Login')
                ->assertSee('These credentials do not match our records.');
        });
    }

    /**
     * Test the basic login when the password is incorrect
     *
     * @group login
     */
    public function testLoginPasswordFailure() {

        $personTryingToLogin = $this->personTryingToLogin;

        $this->browse(function (Browser $browser) use ($personTryingToLogin) {
            $browser->visit('/login')
                ->type('email', $personTryingToLogin['email'])
                ->type('password', 'wrongpassword')
                ->press('Login')
                ->assertSee('These credentials do not match our records.');
        });
    }
}
