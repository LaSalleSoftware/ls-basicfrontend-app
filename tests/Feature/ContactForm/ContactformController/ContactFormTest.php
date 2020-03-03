<?php

namespace Tests\Feature\ContactForm\ContactformController;

// LaSalle Software
use Lasallesoftware\Library\UniversallyUniqueIDentifiers\Models\Uuid;

// Laravel classes
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Test the contact form views.
 */
class ContactFormTest extends TestCase
{
    // Define hooks to migrate the database before and after each test
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('lslibrary:customseed');
    }

    /**
     * See the contact form when the form comes from its own route in its own view 
     * (ie, not via the partial view in another view).
     * 
     * @group Contactform
     * @group ContactformContactformcontroller
     * @group ContactformContactformcontrollerContactform
     * @group ContactformContactformcontrollerContactformSeecontactform
     *
     * @return void
     */
    public function testSeeContactFormTest()
    {
        echo "\n**Now testing Tests\Feature\ContactForm\ContactformController\ContactFormTest**";

        
        // go to the home page
        $response = $this->get('/contactform/contactform');

        // get to the home page ok?
        $response->assertStatus(200); 
        $response->assertSessionHasNoErrors();     
       
        // see the contact form ok?
        // these are the "id" of the contact form's <input> fields
        $response->assertSee('first_name');
        $response->assertSee('surname');
        $response->assertSee('email');
        $response->assertSee('comment');

        // is the UUID ok?
        $uuid = Uuid::orderby('id', 'desc')->take(1)->first();
        $this->assertEquals($uuid->lasallesoftware_event_id, 10);  //10 is "Contact Form"
    }

    /**
     * See the contact form's partial view in the home page.
     * 
     * @group Contactform
     * @group ContactformContactformcontroller
     * @group ContactformContactformcontrollerContactform
     * @group ContactformContactformcontrollerContactformSeepartialcontactforminthehomepagetest
     *
     * @return void
     */
    public function testSeePartialContactFormInHomePageTest()
    {
        // go to the home page
        $response = $this->get('/');

        // get to the home page ok?
        $response->assertStatus(200); 
        $response->assertSessionHasNoErrors();     
       
        // see the contact form (partial view) ok?
        // these are the "id" of the contact form's <input> fields
        $response->assertSee('first_name');
        $response->assertSee('surname');
        $response->assertSee('email');
        $response->assertSee('comment');

        // is the UUID ok?
        $uuid = Uuid::orderby('id', 'desc')->take(1)->first();
        $this->assertEquals($uuid->lasallesoftware_event_id, 9);  //9 is "Client Front-end"
    }
}