<?php

namespace Tests\Feature\ContactForm;

// LaSalle Software
use Lasallesoftware\Library\UniversallyUniqueIDentifiers\Models\Uuid;

// Laravel classes
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Test the contact form security step.
 */
class SecurityTest extends TestCase
{
    // Define hooks to migrate the database before and after each test
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('lslibrary:customseed');
    }

    /**
     * See the security form -- the intermediate "step two" -- of the contact form submission process
     * 
     * @group Contactform
     * @group ContactformSecurity
     * @group ContactformSecuritySeesecurityformtest
     *
     * @return void
     */
    public function testSeeSecurityFormTest()
    {
        echo "\n**Now testing Tests\Feature\ContactForm\SecurityTest**";


        // go to the security form
        // need some form input data
        $response = $this->post('/contactform/security', [
            'first_name' => 'Aaron',
            'surname'    => 'Bloom',
            'email'      => 'a@b.com',
            'comment'    => 'this is my comment!',
        ]);

        // see the form ok?
        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();

        // is the UUID ok?
        $uuid = Uuid::orderby('id', 'desc')->take(1)->first();
        $this->assertEquals($uuid->lasallesoftware_event_id, 11);  // 11 is "Contact Form Submission - Security Form"


        



        
        //$this->assertDatabaseHas('uuids', []);

        // echo 

        

        /*
        $this->assertDatabaseHas('posts', [
            'title' => 'test',
            'body' => 'this is a test'
        ]);
        */
    }
}