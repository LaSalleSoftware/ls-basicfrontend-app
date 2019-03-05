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



// *******************************************************************************************************************
// My LasalleGuard class is based verbatim on Laravel's SessionGuard. Most of the methods I am using from SessionGuard
// are untouched (or not used as I am not implementing basic auth).
//
// As well, many methods depend on the UserProvider contract. I am using the EloquentUserProvider class completely
// untouched, as-is.
// (https://github.com/laravel/framework/blob/5.8/src/Illuminate/Auth/EloquentUserProvider.php)
//
// So I am depending on Laravel a lot. Which is exactly what I am trying to achieve. I am not interested in testing
// The Framework, so I will be testing what I am customizing.
// *******************************************************************************************************************




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

        //-------------------------------------------------
        //  login a user (personbydomain)
        //-------------------------------------------------

        // create a mock uuidGenerator object
        $uuidGenerator = $this->getMockBuilder(UuidGenerator::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        // create a mock LasalleGuard object
        $lasalleguard = $this->getMockBuilder(LasalleGuard::class)
            ->setMethods(['getSessionKey', 'getUserById'])
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $login = new LoginModel();

        $personbydomain_id = 1;
        $logintoken        = $lasalleguard->getLoginToken();
        $uuid              = $uuidGenerator->newUuid();
        $now               = Carbon::now(null);

        $resultId = $login->createNewLoginsRecord([
            'personbydomain_id' => $personbydomain_id,
            'token'             => $logintoken,
            'uuid'              => $uuid,
            'created_at'        => $now,
            'created_by'        => 1,
        ]);

        //-------------------------------------------------
        //  setting up for calling the user() method
        //-------------------------------------------------

        // set up the statement within the user() method
        // let's assume that the session is storing the correct personbydomain_id
        // id = $this->getSessionKey($this->getName());
        $lasalleguard->expects($this->at(0))
            ->method('getSessionKey')
            ->willReturn($personbydomain_id)
        ;

        // set up the statement within the user() method
        // let's assume that the session is storing the correct login token
        // $loginToken = $this->getSessionKey('loginToken');
        $lasalleguard->expects($this->at(1))
            ->method('getSessionKey')
            ->willReturn($logintoken)
        ;





        //$personbydomain_idx = $lasalleguard->getSessionKey(0);
        //$logintokenx = $lasalleguard->getSessionKey(1);

        //echo "\npersonbydomain_id = " . $personbydomain_idx;
        //echo "\nlogintoken = " . $logintokenx;


        // Act
        $resultUser = $lasalleguard->user();

        var_dump($resultUser);


        // Assert
        $this->assertTrue(! is_null($resultUser));

        $this->assertTrue(1 === 1, "hey, false!!");
    }


}
