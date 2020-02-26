<?php

namespace Tests\Feature\ContactForm;

// LaSalle Software
use Lasallesoftware\Contactform\Http\Controllers\ConfirmationController;

// Laravel classes
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Test the contact form's security question.
 */
class SecurityQuestionTest extends TestCase
{
    /**
     * Verify that the security answer is "first_number plus second_number". 
     * 
     * @group Contactform
     * @group ContactformContactform
     * @group ContactformContactformVerifysecurityanswertest
     *
     * @return void
     */
    public function testVerifySecurityAnswerTest()
    {
        $confirmationController = new ConfirmationController;

        $first_number = 4;
        $second_number = 5;

        $answer = $confirmationController->getSecurityAnswer($first_number, $second_number);

        $this->assertEquals($answer, $first_number + $second_number);

    }
}