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
 * @copyright  (c) 2019 The South LaSalle Trading Corporation
 * @license    http://opensource.org/licenses/MIT MIT
 * @author     Bob Bloom
 * @email      bob.bloom@lasallesoftware.ca
 * @link       https://lasallesoftware.ca Blog, Podcast, Docs
 * @link       https://packagist.org/packages/lasallesoftware/lsv2-basicfrontend-app Packagist
 * @link       https://github.com/lasallesoftware/lsv2-basicfrontend-app GitHub
 *
 */

namespace Tests\Unit\Library\Authentication\LoginLogout;

// LaSalle Software classes
use Lasallesoftware\Library\Authentication\Models\Login;
use Lasallesoftware\Library\Authentication\CustomGuards\LasalleGuard;
use Lasallesoftware\Library\UniversallyUniqueIDentifiers\UuidGenerator;

// Laravel classes
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LoginModelTest extends TestCase
{
    // Define hooks to migrate the database before and after each test
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('lslibrary:customseed');
    }

    /**
     * Test that a new login record is inserted into the database
     *
     * @group login
     *
     * @return void
     */
    public function testCreateNewLoginsRecord()
    {
        echo "\n**Now testing Tests\Unit\Library\Authentication\LoginLogout\LoginModelTest**";

        // Arrange
        $lasalleguard = $this->getMockBuilder(LasalleGuard::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $uuidGenerator = $this->getMockBuilder(UuidGenerator::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $logintoken = $lasalleguard->getLoginToken();
        $uuid       = $uuidGenerator->newUuid();
        $now        = Carbon::now(null);

        $data = [
            'personbydomain_id' => 1,
            'token'             => $logintoken,
            'uuid'              => $uuid,
            'created_at'        => $now,
            'created_by'        => 1,
        ];


        // Act
        $login = new Login;

        $resultId = $login->createNewLoginsRecord($data);

        // Assert
        $record = \Lasallesoftware\Library\Authentication\Models\Login::find($resultId);
        // The following gives a message for each failing test, which is handier than the above's message when a test(s) fail
        $this->assertTrue($record->personbydomain_id == 1,'***The login personbydomain_id should be 1***');
        $this->assertTrue($record->token == $logintoken,'***The login token is wrong***');
        $this->assertTrue($record->uuid <> null,'***The uuid is wrong***');
        $this->assertTrue($record->created_at == $now,'***The created_at is wrong***');
        $this->assertTrue($record->created_by == 1,'***The created_by should be 1***');

        $this->assertTrue(is_int($record->personbydomain_id), "***The personbydomain_id must be an integer***");
        $this->assertTrue(is_int($record->created_by), "***The created_by must be an integer***");
    }

    /**
     * Test that a new login record is updated in the database
     *
     * @group login
     *
     * @return void
     */
    public function testupdateExistingLoginsRecord()
    {
        // Arrange
        $lasalleguard = $this->getMockBuilder(LasalleGuard::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $uuidGenerator = $this->getMockBuilder(UuidGenerator::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        // have to insert a record first
        $dataForInsert = [
            'personbydomain_id' => 1,
            'token'             => $lasalleguard->getLoginToken(),
            'uuid'              => $uuidGenerator->newUuid(),
            'created_at'        => Carbon::now(null),
            'created_by'        => 1,
        ];
        $loginmodel = new Login;
        $resultId = $loginmodel->createNewLoginsRecord($dataForInsert);
        $resultModelFromTheInsert =  Login::find($resultId);

        // set up the update
        $logintoken = $lasalleguard->getLoginToken();
        $uuid       = $uuidGenerator->newUuid();
        $dataForUpdate = [
            //'personbydomain_id' => 1,
            'token'             => $logintoken,
            'uuid'              => $uuid,
            'updated_by'        => 1,
        ];


        // Act
        $loginmodel->updateExistingLoginsRecord($dataForUpdate, $resultModelFromTheInsert);


        // Assert
        $resultModelFromTheUpdate =  Login::find($resultId);
        // The following gives a message for each failing test, which is handier than the above's message when a test(s) fail
        $this->assertTrue($resultModelFromTheUpdate->personbydomain_id == 1,'***The login personbydomain_id should be 1***');
        $this->assertTrue($resultModelFromTheUpdate->token == $logintoken,'***The login token is wrong***');
        $this->assertTrue($resultModelFromTheUpdate->uuid == $uuid,'***The uuid is wrong***');
        $this->assertTrue($resultModelFromTheUpdate->updated_at <> null,'***The created_at should have a datetime***');
        $this->assertTrue($resultModelFromTheUpdate->updated_by == 1,'***The created_by should be 1***');
    }

    /**
     * Test that a login record is deleted from the database when given the model to delete
     *
     * @group login
     *
     * @return void
     */
    public function testdeleteExistingLoginsRecord()
    {
        // Arrange
        $lasalleguard = $this->getMockBuilder(LasalleGuard::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $uuidGenerator = $this->getMockBuilder(UuidGenerator::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        // have to insert a record first
        $dataForInsert = [
            'personbydomain_id' => 1,
            'token'             => $lasalleguard->getLoginToken(),
            'uuid'              => $uuidGenerator->newUuid(),
            'created_at'        => Carbon::now(null),
            'created_by'        => 1,
        ];
        $loginmodel = new Login;
        $resultId = $loginmodel->createNewLoginsRecord($dataForInsert);
        $resultModelFromTheInsert =  Login::find($resultId);


        // Act
        $loginmodel->deleteExistingLoginsRecord($resultModelFromTheInsert);


        // Assert
        $this->assertDatabaseMissing('logins', $dataForInsert);
    }
}
