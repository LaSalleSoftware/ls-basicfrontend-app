<?php

namespace Tests\Browser\Authentication;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Request;

use Lasallesoftware\Library\UniversallyUniqueIDentifiers\Models\Uuid;
use Lasallesoftware\Library\Authentication\Models\Login;

class LoggingOutTest extends DuskTestCase
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
     * @group logout
     */
    public function testLoginShouldBeSuccessful()
    {
        echo "\n**Now testing Tests\Browser\Authentication\LoggingOutTest **";

        $personTryingToLogin = $this->personTryingToLogin;

        $this->browse(function (Browser $browser) use ($personTryingToLogin) {
            $browser->visit('/login')
                ->type('email', $personTryingToLogin['email'])
                ->type('password', $personTryingToLogin['password'])
                ->press('Login')
                ->pause(5000)
                ->visit('/logout')
                ->click('@logout-button')
                ->pause(5000)
                ->assertSee('REGISTER')
                ->assertSee('Laravel')
            ;
        });

        // hard coding the values that are expected, made possible by my database table seeding
        $this->assertDatabaseMissing('logins', ['personbydomain_id' => 1]);
        $this->assertDatabaseMissing('logins', ['uuid' => Uuid::find(2)->uuid]);
        $this->assertDatabaseMissing('logins', ['created_by' => 1]);
    }
}
