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

namespace Tests\Unit\Library\Database;

// Laravel classes
use Tests\TestCase;

// LaSalle Software classes
use Lasallesoftware\Library\Database\Migrations\BaseMigration;

class BaseMigrationTest extends TestCase
{
    /**
     * Migrations in production for the admin LaSalle Software app should run
     *
     * @return void
     */
    public function testRunMigrationInProductionForAdmin()
    {
        echo "\n**Now testing the Tests\Unit\Library\Database\BaseMigrationTest class**";

        // Arrange
        $baseMigration    = new BaseMigration();
        $app_env          = "production";
        $lasalle_app_name = "adminbackendapp";

        // Act
        $result = $baseMigration->doTheMigration($app_env, $lasalle_app_name);

        // Assert
        $this->assertTrue($result === true, '***The result should be true***');
    }

    /**
     * Migrations in production for the non-admin LaSalle Software apps should *not* run
     *
     * @return void
     */
    public function testRunMigrationInProductionForNonAdmin()
    {
        // Arrange
        $baseMigration    = new BaseMigration();
        $app_env          = "production";
        $lasalle_app_name = "genericapp";

        // Act
        $result = $baseMigration->doTheMigration($app_env, $lasalle_app_name);

        // Assert
        $this->assertTrue($result === false, '***The result should be false***');
    }

    /**
     * Migrations in non-production should run for all LaSalle Software apps
     *
     * @return void
     */
    public function testRunMigrationInNonProductionFordmin()
    {
        // Arrange
        $baseMigration    = new BaseMigration();
        $app_env          = "production";
        $lasalle_app_name = "adminbackendapp";

        // Act
        $result = $baseMigration->doTheMigration($app_env, $lasalle_app_name);

        // Assert
        $this->assertTrue($result === true, '***The result should be true***');
    }
}
