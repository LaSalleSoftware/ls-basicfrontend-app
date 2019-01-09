<?php

namespace Tests\Unit\Library\Uuid;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Lasallesoftware\Library\UniversallyUniqueIDentifiers\UuidFactory;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        echo "testBasicTest";

        $uuidFactory = new UuidFactory();
        $x = $uuidFactory->bob();
        $this->assertTrue($x == "bob");
    }
}