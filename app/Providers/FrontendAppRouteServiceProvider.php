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
 * @copyright  (c) 2019-2020 The South LaSalle Trading Corporation
 * @license    http://opensource.org/licenses/MIT
 * @author     Bob Bloom
 * @email      bob.bloom@lasallesoftware.ca
 *
 * @see       https://lasallesoftware.ca
 * @see       https://packagist.org/packages/lasallesoftware/ls-basicfrontend-app
 * @see       https://github.com/LaSalleSoftware/ls-basicfrontend-app
 */

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

use Illuminate\Support\Facades\Route;

class FrontendAppRouteServiceProvider extends ServiceProvider
{
    /**
     *    ** This class is in conjunction with Lasallesoftware\Laravelapp\Providers\RouteServiceProvider, *not* as its replacement! **
     *
     * @return void
     */
    public function boot()
    {
        $this->routes(function () {
           
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'))
            ;
        });
    }
}