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

class LasalleGuardCreateFullCredentialsTest extends TestCase
{
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
     *
     * @return void
     */
    public function testFullSetOfCredentialsForAuthenticationWithKeyEqualEmail()
    {
        echo "\n**Now testing Tests\Unit\Library\Authentication\LoginLogout;\LasalleGuardCreateFullCredentialsTest**";

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
}


