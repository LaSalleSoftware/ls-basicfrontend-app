<?php

/**
 * This file is part of the Lasalle Software Basic Frontend App
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  (c) 2018 The South LaSalle Trading Corporation
 * @license    http://opensource.org/licenses/MIT MIT
 * @author     Bob Bloom
 * @email      bob.bloom@lasallesoftware.ca
 * @link       https://lasallesoftware.ca Blog, Podcast, Docs
 * @link       https://packagist.org/packages/lasallesoftware/lsv2-basicfrontend-app Packagist
 * @link       https://github.com/lasallesoftware/lsv2-basicfrontend-app GitHub
 *
 */

namespace Tests\Unit\Library\Uuid;

// Laravel classes
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

// LaSalle Software classes
use Lasallesoftware\Library\UniversallyUniqueIDentifiers\UuidGenerator;

class UuidTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('lslibrary:customseed');
    }

    /**
     * The UUID should be 36 characters long. If not, the Ramsey package might have changed the UUID,
     * and the UUID could be longer than the 36char UUID database field
     *
     * @return void
     */
    public function testUuidShouldBe36CharactersLong()
    {
        echo "\n**Now testing the Tests\Unit\Library\Uuid\UuidfactoryTest class**";

        $uuidGenerator = new UuidGenerator();
        $newUuid = $uuidGenerator->newUuid();

        $this->assertTrue(strlen($newUuid) === 36, '***The uuid string length should be 36***');
    }

    /**
     * Testing that the UUID is INSERTed into the database with the default values.
     * The default values are:
     *  lasallesoftware_event_id = 1
     *  comments = null
     *  created_by = 1
     *  created_at = now()
     *
     * @return void
     */
    public function testInsertUuidWithDefaultValues()
    {
        // Arrange
        $uuidGenerator = new UuidGenerator();
        $uuid = factory(\Lasallesoftware\Library\UniversallyUniqueIDentifiers\Models\Uuid::class)->make([
            'comments' => null,
        ]);

        // Act
        $uuidGenerator->insertUuidIntoDatabase(
            $uuid['lasallesoftware_event_id'],
            $uuid['uuid'],
            $uuid['comments'],
            $uuid['created_by'],
            $uuid['created_at']
        );

        /*
        echo "\nevent id = " . $uuid['lasallesoftware_event_id'];
        echo "\nuuid = " . $uuid['uuid'];
        echo "\ncomments = " . $uuid['comments'];
        echo "\ncreated by = " . $uuid['created_by'];
        echo "\ncreated at = " . $uuid['created_at'];
        echo "\n\n";
        */

        // Assert
        $record = \Lasallesoftware\Library\UniversallyUniqueIDentifiers\Models\Uuid::latest()->first();
        /*
        $this->assertDatabaseHas('uuids', [
            'lasallesoftware_event_id' => 1,
            'uuid'                     => $uuid['uuid'],
            'comments'                 => $uuid['comments'],
            'created_by'               => $uuid['created_by'],
            'created_at'               => $uuid['created_at']
        ]);
        */

        // The following gives a message for each failing test, which is handier than the above's message when a test(s) fail
        $this->assertTrue($record->lasallesoftware_event_id == 1,'***The uuid lasallesoftware_event_id should default to 1***');
        $this->assertTrue($record->comments === null,'***The uuid comment should default to null***');
        $this->assertTrue($record->created_by == 1,'***The uuid created_by default should be 1***');
    }

    /**
     * Testing that the UUID is INSERTed into the database with no (null) comments.
     *
     * @return void
     */
    public function testInsertUuidWithComments()
    {
        // Arrange
        $uuidGenerator = new UuidGenerator();
        $uuid = factory(\Lasallesoftware\Library\UniversallyUniqueIDentifiers\Models\Uuid::class)->make();

        // Act
        $uuidGenerator->insertUuidIntoDatabase(
            $uuid['lasallesoftware_event_id'],
            $uuid['uuid'],
            $uuid['comments'],
            $uuid['created_by'],
            $uuid['created_at']
        );

        // Assert
        $record = \Lasallesoftware\Library\UniversallyUniqueIDentifiers\Models\Uuid::latest()->first();
        $this->assertTrue($record->comments <> null, '***The uuid comment should be not-null***');
    }


    // done? now, go write explanation in lslibrary:customseed!!

}
