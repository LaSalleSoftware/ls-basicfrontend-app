<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        echo "\n**Now testing the Tests\Feature\ExampleTest class**";
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
