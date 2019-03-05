<?php

namespace Tests\Browser\Authentication;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Request;

use Lasallesoftware\Library\UniversallyUniqueIDentifiers\Models\Uuid;
use Lasallesoftware\Library\Authentication\Models\Login;

class LoggingInTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $personTryingToLogin;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('lslibrary:customseed');

        $this->personTryingToLogin = [
            'email'    => 'bob.bloom@lasallesoftware.ca',
            'password' => 'secret',
        ];
    }

    /**
     * Test that the correct credentials result in a successful login
     *
     * @group login
     */
    public function testLoginShouldBeSuccessful()
    {
        echo "\n**Now testing Tests\Browser\Authentication\LoggingInTest**";

        $personTryingToLogin = $this->personTryingToLogin;

        $this->browse(function (Browser $browser) use ($personTryingToLogin) {
            $browser->visit('/login')
                //->assertSee('Login')
                ->type('email',    $personTryingToLogin['email'])
                ->type('password', $personTryingToLogin['password'])
                ->press('Login')
                ->pause(5000)
                ->assertPathIs('/home')
                ->assertSee('You are logged in!')
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
     * Test that the login is unsuccessful when the wrong email is used
     *
     * @group login
     */
    public function testLoginShouldFailWithTheWrongEmail() {

        $personTryingToLogin = $this->personTryingToLogin;

        $this->browse(function (Browser $browser) use ($personTryingToLogin) {
            $browser->visit('/login')
                ->type('email', 'wrong@email.com')
                ->type('password', $personTryingToLogin['password'])
                ->press('Login')
                ->assertSee('These credentials do not match our records.');
        });

        // hard coding the values that are expected, made possible by my database table seeding
        $this->assertDatabaseMissing('logins', ['personbydomain_id' => 1]);
        $this->assertDatabaseMissing('logins', ['uuid' => Uuid::find(2)->uuid]);
        $this->assertDatabaseMissing('logins', ['created_by' => 1]);
    }

    /**
     * Test that the login is unsuccessful when the wrong password is used
     *
     * @group login
     */
    public function testLoginShouldFailWithTheWrongPassword() {

        $personTryingToLogin = $this->personTryingToLogin;

        $this->browse(function (Browser $browser) use ($personTryingToLogin) {
            $browser->visit('/login')
                ->type('email', $personTryingToLogin['email'])
                ->type('password', 'wrongpassword')
                ->press('Login')
                ->assertSee('These credentials do not match our records.');
        });

        // hard coding the values that are expected, made possible by my database table seeding
        $this->assertDatabaseMissing('logins', ['personbydomain_id' => 1]);
        $this->assertDatabaseMissing('logins', ['uuid' => Uuid::find(2)->uuid]);
        $this->assertDatabaseMissing('logins', ['created_by' => 1]);

        //echo "\n session loginToken = " . Request::session()->has('loginToken') . "\n";
    }
}
