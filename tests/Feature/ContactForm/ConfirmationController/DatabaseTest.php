<?php

namespace Tests\Feature\ContactForm;

// LaSalle Software
use Lasallesoftware\Contactform\Http\Controllers\ConfirmationController;
use Lasallesoftware\Library\UniversallyUniqueIDentifiers\UuidGenerator;

// Laravel classes
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Test the contact form's insert into the contact form database table.
 */
class DatabaseTest extends TestCase
{
    // Define hooks to migrate the database before and after each test
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('lslibrary:customseed');
    }    

    /**
     * Verify that the contact form input data is inserted into the contact_form table  
     * 
     * @group Contactform
     * @group ContactformConfirmationcontroller
     * @group ContactformConfirmationcontrollerDatabase
     * @group ContactformConfirmationcontrollerDatabaseContactforminputfataIsinsertedintothecontactformtable
     *
     * @return void
     */
    public function testContactFormInputDataIsInsertedIntoTheContactformTable()
    {
        echo "\n**Now testing Tests\Feature\ContactForm\ConfirmationTest\DatabaseTest**";

        // for security question
        $first_number = 5;
        $second_number = 6;

        // need the UUID
        $uuidGenerator = new UuidGenerator();
        $uuid = $uuidGenerator->createUuid(11, 'created by Tests\Feature\ContactForm\ConfirmationTest::testContactFormInputDataIsInsertedIntoTheContactformTable', 1);

        $response = $this->post('/contactform/confirmation', [
            'first_name'      => 'Blues Boy',
            'surname'         => 'King',
            'email'           => 'bb@blues.com',
            'comment'         => 'this is my comment!',
            'uuid'            => $uuid,
            'first_number'    => $first_number,
            'second_number'   => $second_number,
            'security_answer' => 11,
        ]);

        $this->assertDatabaseHas('contact_form', ['first_name' => 'Blues Boy']);
        $this->assertDatabaseHas('contact_form', ['surname'    => 'King']);
        $this->assertDatabaseHas('contact_form', ['email'      => 'bb@blues.com']);
        $this->assertDatabaseHas('contact_form', ['message'    => 'this is my comment!']);
        $this->assertDatabaseHas('contact_form', ['uuid'       => $uuid]);
        $this->assertDatabaseHas('contact_form', ['personbydomains_id' => NULL]);
    }

    /**
     * Verify that the personbydomains_id is 2 in the contact_form database table
     * 
     * @group Contactform
     * @group ContactformConfirmationcontroller
     * @group ContactformConfirmationcontrollerDatabase
     * @group ContactformConfirmationcontrollerDatabasePersonbydomainsexists
     *
     * @return void
     */
    public function testPersonbydomainsExists()
    {
        echo "\n**Now testing Tests\Feature\ContactForm\ConfirmationTest**";

        // for security question
        $first_number = 5;
        $second_number = 6;

        // need the UUID
        $uuidGenerator = new UuidGenerator();
        $uuid = $uuidGenerator->createUuid(11, 'created by Tests\Feature\ContactForm\ConfirmationTest::testContactFormInputDataIsInsertedIntoTheContactformTable', 1);

        $response = $this->post('/contactform/confirmation', [
            'first_name'      => 'Blues Boy',
            'surname'         => 'King',
            'email'           => 'bbking@kingofblues.com',
            'comment'         => 'this is my comment!',
            'uuid'            => $uuid,
            'first_number'    => $first_number,
            'second_number'   => $second_number,
            'security_answer' => 11,
        ]);

        $this->assertDatabaseHas('contact_form', ['personbydomains_id' => 2]);
    }
}