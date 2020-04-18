<?php

namespace Tests\Feature\ContactForm\ConfirmationController;

// LaSalle Software
use Lasallesoftware\Contactform\Http\Controllers\ConfirmationController;

// Laravel classes
use Tests\TestCase;

/**
 * Test the getPersonbydomainsId() method.
 */
class PersonbydomainsTest extends TestCase
{
    /**
     * Verify that the personbydomains_id will be null (email not found in the personbydomains table)
     * 
     * @group Contactform
     * @group ContactformConfirmationcontroller
     * @group ContactformConfirmationcontrollerPersonbydomains
     * @group ContactformConfirmationcontrollerPersonbydomainsIsnull
     *
     * @return void
     */
    public function testIsNull()
    {
        echo "\n**Now testing Tests\Feature\ContactForm\ConfirmationTest\PersonbydomainsTest**";

        $confirmationController = new ConfirmationController;

        $personbydomains_id = $confirmationController->getPersonbydomainsId('email@sampleemail.com');

        $this->assertEquals($personbydomains_id, null);
    }

    /**
     * Verify that the personbydomains_id will be 2 (email is found in the personbydomains table)
     * 
     * @group Contactform
     * @group ContactformConfirmationcontroller
     * @group ContactformConfirmationcontrollerPersonbydomains
     * @group ContactformConfirmationcontrollerPersonbydomainsIsnotnull
     *
     * @return void
     */
    public function testNotNull()
    {
        $confirmationController = new ConfirmationController;

        $personbydomains_id = $confirmationController->getPersonbydomainsId('bbking@kingofblues.com');

        $this->assertEquals($personbydomains_id, 2);
    }


}