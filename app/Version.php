<?php

/**
 * This file is part of the LaSalle Software Basic Front-end application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  (c) 2019-2021 The South LaSalle Trading Corporation
 * @license    http://opensource.org/licenses/MIT
 * @author     Bob Bloom
 * @email      bob.bloom@lasallesoftware.ca
 *
 * @see       https://lasallesoftware.ca
 * @see       https://packagist.org/packages/lasallesoftware/ls-basicfrontend-app
 * @see       https://github.com/LaSalleSoftware/ls-basicfrontend-app
 */

namespace App;

class Version
{
    /**
     * This package's version number.
     *
     * @var string
     */
    const VERSION = '2.4.4';

    /**
     * This package's release date.
     *
     * @var string
     */
    const RELEASEDATE = 'April 23, 2021';

    /**
     * This package's name.
     *
     * @var string
     */
    const PACKAGE = 'Basic front-end application for my LaSalle Software';

    /**
     * Get the version number of this package.
     *
     * @return string
     */
    public function version()
    {
        return static::VERSION;
    }

    /**
     * Get the release date of this package.
     *
     * @return string
     */
    public function releasedate()
    {
        return static::RELEASEDATE;
    }

    /**
     * Get the name of this package.
     *
     * @return string
     */
    public function packageName()
    {
        return static::PACKAGE;
    }
}
