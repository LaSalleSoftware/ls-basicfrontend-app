<?php

namespace Tests\Feature\ContactForm\ConfirmationController;

// LaSalle Software
use Lasallesoftware\Contactform\Http\Controllers\ConfirmationController\ConfirmationController;

// Laravel classes
use Tests\TestCase;

/**
 * Test the contact form's security question.
 */
class SecurityQuestionTest extends TestCase
{
    /**
     * Verify that the security answer is "first_number plus second_number". 
     * 
     * @group Contactform
     * @group ContactformConfirmationcontroller
     * @group ContactformConfirmationcontrollerSecurityquestion
     * @group ContactformConfirmationcontrollerSecurityquestionSecurityanswer
     *
     * @return void
     */
    public function testVerifySecurityAnswerTest()
    {
        echo "\n**Now testing Tests\Feature\ContactForm\ConfirmationTest\SecurityQuestionTest**";

        $confirmationController = new ConfirmationController;

        $first_number = 4;
        $second_number = 5;

        $answer = $confirmationController->getSecurityAnswer($first_number, $second_number);

        $this->assertEquals($answer, $first_number + $second_number);

    }
}