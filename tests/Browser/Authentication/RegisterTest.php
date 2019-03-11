<?php

namespace Tests\Browser\Authentication;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Request;

use Lasallesoftware\Library\UniversallyUniqueIDentifiers\Models\Uuid;
use Lasallesoftware\Library\Profiles\Models\Person;
use Lasallesoftware\Library\Profiles\Models\Email;
use Lasallesoftware\Library\Profiles\Models\Person_email;
use Lasallesoftware\Library\Authentication\Models\Personbydomain;
use Lasallesoftware\Library\Profiles\Models\Lookup_domain;
use Lasallesoftware\Library\Authentication\Models\Login;


class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $personTryingToLogin;


    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('lslibrary:customseed');

        $this->personTryingToRegister = [
            'first_name' => 'Richard',
            'surname'    => 'Blaine',
            'email'      => 'rick@cafeamericain.com',
            'password'   => 'secret',
        ];
    }

    /**
     * Test that the correct credentials result in a successful login.
     *
     * Basic scenario:
     *  ** fresh new person not yet in the database
     *  ** first_name and surname are ok
     *  ** email is unique
     *  ** password is ok
     *
     * @group register
     */
    public function testRegisterNewPersonBasicScenarioShouldBeSuccessful()
    {
        echo "\n**Now testing Tests\Browser\Authentication\RegisterTest **";

        $personTryingToRegister = $this->personTryingToRegister;

        $this->browse(function (Browser $browser) use ($personTryingToRegister) {
            $browser->visit('/register')
                ->assertSee('Register')
                ->type('first_name',    $personTryingToRegister['first_name'])
                ->type('surname',    $personTryingToRegister['surname'])
                ->type('email',    $personTryingToRegister['email'])
                ->type('password', $personTryingToRegister['password'])
                ->type('password_confirmation', $personTryingToRegister['password'])
                ->press('Register')
                ->pause(5000)
                ->assertPathIs('/home')
                ->assertSee('You are logged in!')
            ;
        });

        // UUID model created
        $uuid = Uuid::orderBy('created_at', 'desc')->first();


        // EMAILS database table
        $email = Email::orderBy('created_at', 'desc')->first();

        $this->assertTrue($email->id == 2,'***The id is wrong***');
        $this->assertTrue($email->email_type_id == 1,'***The email_type_id is wrong***');
        $this->assertTrue($email->email_address == $personTryingToRegister['email'],'***The email_address is wrong***');
        $this->assertTrue($email->description == 'Created by the Register Form.','***The descripotion is wrong***');
        $this->assertTrue($email->comments == 'Created by the Register Form.','***The comments is wrong***');
        $this->assertTrue($email->uuid == $uuid->uuid,'***The uuid is wrong***');
        $this->assertTrue($email->created_at <> null,'***The created_at is wrong***');
        $this->assertTrue($email->created_by == 1,'***The created_by is wrong***');


        // PERSONS database table
        $person = Person::orderBy('created_at', 'desc')->first();

        $this->assertTrue($person->id == 3,'***The id is wrong***');
        $this->assertTrue($person->first_name == $personTryingToRegister['first_name'],'***The first_name is wrong***');
        $this->assertTrue($person->surname == $personTryingToRegister['surname'],'***The surname is wrong***');
        $this->assertTrue($person->description == 'Created by the Register Form.','***The description is wrong***');
        $this->assertTrue($person->comments == 'Created by the Register Form.','***The comments is wrong***');
        $this->assertTrue($person->uuid == $uuid->uuid,'***The uuid is wrong***');
        $this->assertTrue($person->created_at <> null,'***The created_at is wrong***');
        $this->assertTrue($person->created_by == 1,'***The created_by is wrong***');


        // PERSON_EMAIL database table
        $person_email = Person_email::find(2);

        $this->assertTrue($person_email->id == 2,'***The id is wrong***');
        $this->assertTrue($person_email->person_id == 3,'***The person_id is wrong***');
        $this->assertTrue($person_email->email_id == 2,'***The email_id is wrong***');


        // PERSONBYDOMAINS database table
        $lookup_domain = Lookup_domain::find(1)->first();
        $personbydomain = Personbydomain::orderBy('created_at', 'desc')->first();

        $this->assertTrue($personbydomain->id == 2,'***The id is wrong***');
        $this->assertTrue($personbydomain->person_id == $person->id, '***The person_id is wrong***');
        $this->assertTrue($personbydomain->person_first_name == $person->first_name,'***The first_name is wrong***');
        $this->assertTrue($personbydomain->person_surname == $person->surname,'***The surname is wrong***');
        $this->assertTrue($personbydomain->email == $email->email_address,'***The email address is wrong***');
        $this->assertTrue($personbydomain->password <> null,'***The password is wrong***');
        $this->assertTrue($personbydomain->lookup_domain_id == $lookup_domain->id, '***The lookup domain id is wrong***');
        $this->assertTrue($personbydomain->lookup_domain_title == $lookup_domain->title, '***The lookup domain title is wrong***');
        $this->assertTrue($personbydomain->uuid == $uuid->uuid,'***The uuid is wrong***');
        $this->assertTrue($personbydomain->created_at <> null,'***The created_at is wrong***');
        $this->assertTrue($personbydomain->created_by == 1,'***The created_by is wrong***');


        // LOGINS database table
        $login = Login::orderBy('created_at', 'desc')->first();

        $this->assertTrue($login->id == 1, '***The id is wrong***');
        $this->assertTrue($login->personbydomain_id == $personbydomain->id, '***The personbydomain_id is wrong***');
        $this->assertTrue($login->token <> null, "***The login token is not null");
        $this->assertTrue($login->uuid == $uuid->uuid,'***The uuid is wrong***');
        $this->assertTrue($personbydomain->created_at <> null,'***The created_at is wrong***');
        $this->assertTrue($personbydomain->created_by == 1,'***The created_by is wrong***');
    }
}
