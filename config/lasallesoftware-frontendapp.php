<?php

/**
 * This file is part of the Lasalle Software Front-end Application
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
 * @link       https://lasallesoftware.ca
 * @link       https://packagist.org/packages/lasallesoftware/lsv2-basicfrontend-app
 * @link       https://github.com/lasallesoftware/lsv2-basicfrontend-app
 *
 */

return [

    /*
    |--------------------------------------------------------------------------
    | The key this front-end application uses for JWT
    |--------------------------------------------------------------------------
    |
    | JWT is encrypted using this key.
    |
    | The administrative backend app must have this key to decrypt the JWT.
    |
    | Set in the .env file.
    |
    */
    'lasalle_jwt_key' => env('LASALLE_JWT_KEY'),

    /*
	|--------------------------------------------------------------------------
	| Front-end blade view folder's path
	|--------------------------------------------------------------------------
	|
	| Where is the blade folder that you are using?
	|
    | The LaSalle UI package's "base" folder is the default.
	|
	*/
    'lasalle_path_to_front_end_view_path' => 'lasallesoftwarelasalleui::base',

];
