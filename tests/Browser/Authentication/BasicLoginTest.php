<?php

namespace Tests\Browser\Authentication;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Request;

use Lasallesoftware\Library\UniversallyUniqueIDentifiers\Models\Uuid;
use Lasallesoftware\Library\Authentication\Models\Login;

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
            //'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'password' => 'secret',
        ];

        //$this->artisan('lslibrary:customclearsessions');
    }

    /**
     * Test the basic login.
     *
     * @group login1
     */
    public function testBasicLogin()
    {
        echo "\n**Now testing Tests\Browser\Authentication\BasicLoginTest**";

        $personTryingToLogin = $this->personTryingToLogin;

        $this->browse(function (Browser $browser) use ($personTryingToLogin) {
            $browser->visit('/login')
                //->assertSee('Login')
                ->type('email',    $personTryingToLogin['email'])
                ->type('password', $personTryingToLogin['password'])
                ->press('Login')
                ->pause(5000)
                ->assertPathIs('/home')
                //->assertSee('You are logged in!')
                //->logout()
             ;
        });

        // hard coding the values that are expected, made possible by my database table seeding
        $this->assertDatabaseHas('logins', ['personbydomain_id' => 1]);
        $this->assertDatabaseHas('logins', ['uuid' => Uuid::find(2)->uuid]);
        $this->assertDatabaseHas('logins', ['created_by' => 1]);

        // the login token is saved in the request object as a request property, so cannot retrieve
        // it in this test. So, just making sure that the logins table's token field is not null
        $this->assertTrue(Login::find(1)->token <> null);

        //TODO: logout
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
