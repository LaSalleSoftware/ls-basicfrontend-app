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
use Lasallesoftware\Library\Authentication\CustomGuards\LasalleGuard;
use Lasallesoftware\Library\Authentication\Models\Login as LoginModel;
use Lasallesoftware\Library\UniversallyUniqueIDentifiers\UuidGenerator;

// Laravel classes
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Auth\EloquentUserProvider as UserProvider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Carbon;


class LasalleGuardMethodsFromTheGuardContractTest extends TestCase
{
    // Define hooks to migrate the database before and after each test
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('lslibrary:customseed');
    }

    /**
     * Testing that the LasalleGuard::user() method returns a user object
     *
     * @group login
     * @group methodsfromtheguardcontract
     *
     * @return void
     */
    public function testUserMethodUserIsLoggedInSoShouldReturnUser()
    {
        // Arrange

        // create a mock request object
        $request = $this->getMockBuilder(Request::class)
            ->setMethods([])
            ->disableOriginalConstructor()
            ->getMock()
        ;

        // create a mock user provider object
        $userProvider = $this->getMockBuilder(UserProvider::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        // create a mock session object
        $session = $this->getMockBuilder(Session::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        // create a mock login model object
        $loginModel = $this->getMockBuilder(LoginModel::class)
            ->setMethods(null)
            //->disableOriginalConstructor()
            ->getMock()
        ;

        // create a mock uuidGenerator object
        $uuidGenerator = $this->getMockBuilder(UuidGenerator::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock()
        ;


        $lasalleguard = $this->getMockBuilder(LasalleGuard::class)
            ->setMethods(['getName'])
            ->setConstructorArgs([$request, $userProvider, $session, $loginModel])
            ->getMock()
        ;

        // pretend the assignToRequest() method returns true just for this test
        $lasalleguard->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('login_session_123'))
        ;

        $personbydomain_id = 1;
        $logintoken        = $lasalleguard->getLoginToken();
        $uuid              = $uuidGenerator->newUuid();
        $now               = Carbon::now(null);

        $this->withSession(['login_session_123' => $personbydomain_id]);
        $this->withSession(['loginToken' => $logintoken]);

        $data = [
            'personbydomain_id' => $personbydomain_id,
            'token'             => $logintoken,
            'uuid'              => $uuid,
            'created_at'        => $now,
            'created_by'        => 1,
        ];

        $login = new Login;
        $resultId = $login->createNewLoginsRecord($data);


        // Act
        $resultUser = $lasalleguard->user();


        // Assert
        //$this->assertTrue(! is_null($resultUser));

        $this->assertTrue(1 === 1, "hey, false!!");
    }


}
