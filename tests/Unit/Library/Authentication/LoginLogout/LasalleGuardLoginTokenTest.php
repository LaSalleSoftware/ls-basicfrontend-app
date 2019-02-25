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

// Laravel classes
use Tests\TestCase;

class LasalleGuardLoginTokenTest extends TestCase
{
    /**
     * The login token should be 40 characters long.
     *
     * @group login
     *
     * @return void
     */
    public function testLoginTokenShouldBe40CharactersLong()
    {
        echo "\n**Now testing Tests\Unit\Library\Authentication\LoginLogout\LasalleGuardLoginTokenTest**";

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
}
