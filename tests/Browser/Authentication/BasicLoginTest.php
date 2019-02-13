<?php

namespace Tests\Browser\Authentication;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lasallesoftware\Library\Authentication\Models\User;

class BasicLoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('lslibrary:customseed');

        $this->user = factory(User::class)->create([
            'email' => 'krugerbloom@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        ]);
    }

    /**
     * Test the basic login.
     *
     * @group login
     */
    public function testBasicLogin()
    {
        echo "\n**Now testing the Tests\Browser\Authentication\BasicLoginTest class**";

        $user = $this->user;

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'secret')
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

        $this->browse(function (Browser $browser){
            $browser->visit('/login')
                ->type('email', 'someemail@afakedomain.com')
                ->type('password', 'secret')
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

        $user = $this->user;

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'wrongpassword')
                ->press('Login')
                ->assertSee('These credentials do not match our records.');
        });
    }
}
