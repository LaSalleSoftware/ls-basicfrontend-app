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


// *******************************************************************
// *** SEE COMMENTS IN LasalleGuardMethodsFromTheGuardContractTest ***
// *******************************************************************


namespace Tests\Unit\Library\Authentication\LoginLogout;

// LaSalle Software classes
use Lasallesoftware\Library\Authentication\CustomGuards\LasalleGuard;
use Lasallesoftware\Library\Authentication\Models\Login;
use Lasallesoftware\Library\UniversallyUniqueIDentifiers\UuidGenerator;

// Laravel classes
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Carbon;

class LasalleGuardMethodsByBobTest extends TestCase
{
    // Define hooks to migrate the database before and after each test
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('lslibrary:customseed');
    }

    /**
     * Testing that the LasalleGuard::createFullCredentials() method works, using the "email" field (key).
     *
     * The login form lacks a variable with the name of the domain the person logging in belongs to.
     * So, it is added here.
     *
     * The email field in the Personbydomains table is "primary_email_address", so need to make
     * sure that the credentials array uses this field name (key)
     *
     * method: createFullCredentials($partialCredentials)
     *
     * @group login
     * @group methodsbybob
     *
     * @return void
     */
    public function testFullSetOfCredentialsForAuthenticationWithKeyEqualEmail()
    {
        echo "\n**Now testing Tests\Unit\Library\Authentication\LoginLogout\LasalleGuardMethodsByBobTest**";

        // Arrange
        // found this article to be helpful:
        // https://jtreminio.com/blog/unit-testing-tutorial-part-v-mock-methods-and-overriding-constructors/
        $lasalleguard = $this->getMockBuilder(LasalleGuard::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        // *** key = "email" ***
        $partialCredentials = [
            'email'    => 'bob.bloom@lasallesoftware.ca',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        ];

        // Act
        $fullCredentials = $lasalleguard->createFullCredentials($partialCredentials);

        // Assert
        $this->assertArrayHasKey('primary_email_address', $fullCredentials);
        $this->assertArrayHasKey('lookup_domain_title',   $fullCredentials);
        $this->assertArrayHasKey('password',              $fullCredentials);
    }

    /**
     * Testing that the LasalleGuard::createFullCredentials() method works, using the "email" field (key).
     *
     * Similar to the test above.
     *
     * @group login
     * @group methodsbybob
     *
     * @return void
     */
    public function testFullSetOfCredentialsForAuthenticationWithKeyEqualPrimaryemailaddress()
    {
        // Arrange
        $lasalleguard = $this->getMockBuilder(LasalleGuard::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        // *** key = "primary_email_address" ***
        $partialCredentials = [
            'primary_email_address' => 'bob.bloom@lasallesoftware.ca',
            'password'              => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        ];

        // Act
        $fullCredentials = $lasalleguard->createFullCredentials($partialCredentials);

        // Assert
        $this->assertArrayHasKey('primary_email_address', $fullCredentials);
        $this->assertArrayHasKey('lookup_domain_title',   $fullCredentials);
        $this->assertArrayHasKey('password',              $fullCredentials);
    }

    /**
     * The login token should be 40 characters long.
     *
     * @group login
     * @group methodsbybob
     *
     * @return void
     */
    public function testLoginTokenShouldBe40CharactersLong()
    {
        // Arrange
        $lasalleguard = $this->getMockBuilder(LasalleGuard::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        // Act
        $token = $lasalleguard->getLoginToken();

        // Assert
        $this->assertTrue(strlen($token) === 40, '***The login token string length should be 40***');
    }

    /**
     * The getLogin method should return a single logins database table record (actually, returns model).
     *
     * @group login
     * @group methodsbybob
     *
     * @return void
     */
    public function testGetLoginShouldReturnSingleRecord()
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

        $login = new Login;
        $resultId = $login->createNewLoginsRecord($data);

        // Act
        // what the $where looks like in LasalleGuard::user()
        $where = [
            'personbydomain_id' => 1,
            'token'             => $logintoken,
        ];
        $result = $lasalleguard->getLogin($where);

        // Assert
        $this->assertTrue($result->count() == 1, '***There should be one login record***');
    }

    /**
     * The getLogin method should return null, indicating that no record was found.
     *
     * @group login
     * @group methodsbybob
     *
     * @return void
     */
    public function testGetLoginShouldReturnNull()
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

        $login = new Login;
        $resultId = $login->createNewLoginsRecord($data);

        // Act
        // what the $where looks like in LasalleGuard::user()
        $where = [
            'personbydomain_id' => 1,
            'token'             => 'abc', // wrong, as most likely scenario is that the login token is not
                                          // in the logins database table
        ];
        $result = $lasalleguard->getLogin($where);

        // Assert
        $this->assertTrue(is_null($result), '***There should be one login record***');
    }
}
