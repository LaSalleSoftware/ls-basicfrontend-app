<?php

namespace Tests\Browser\Authentication;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lasallesoftware\Library\Authentication\Models\User;

class BasicRegistrationTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('lslibrary:customseed');
    }

    /*
     * Test the basic registration. No email verification!
     *
     * @group registration
     */
    public function testBasicRegistration()
    {
        echo "\n**Now testing the Tests\Browser\Authentication\BasicRegistrationTest class**";

        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'Bob Bloom')
                ->type('email', 'email@email.com')
                ->type('password', 'secret')
                ->type('password_confirmation', 'secret')
                ->press('Register')
                ->pause(2000)
                ->assertSee('You are logged in!')
                ->logout();
        });

        $record = \Lasallesoftware\Library\Authentication\Models\User::latest()->first();

        $this->assertTrue($record->name == 'Bob Bloom', '***The user name should be "Bob Bloom"***');
        $this->assertTrue($record->email == 'email@email.com', '***The user email should be "email@email.com"***');
        $this->assertTrue($record->password <> null, '***The user password should not be null***');
    }
}
