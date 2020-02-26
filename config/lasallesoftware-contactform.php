<?php

/**
 * This file is part of the Lasalle Software contact form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  (c) 2019-2020 The South LaSalle Trading Corporation
 * @license    http://opensource.org/licenses/MIT MIT
 * @author     Bob Bloom
 * @email      bob.bloom@lasallesoftware.ca
 * @link       https://lasallesoftware.ca
 * @link       https://packagist.org/packages/lasallesoftware/lsv2-contactform-pkg
 * @link       https://github.com/LaSalleSoftware/lsv2-contactform-pkg
 *
 */

return [

    /*
    |--------------------------------------------------------------------------
    | The View Files Are Located In Which Package?
    |--------------------------------------------------------------------------
    |
    | The controllers display view files.
    | 
    | Instead of using a hard coded "lasallesoftwarecontactform" (this package),
    | which means you have to publish the view (blade) files (to your public folder)
    | and then edit them directly -- which you can do if you want -- I want the 
    | ability to do custom contact form views in a custom UI package. 
    | 
    | So I created this config parameter. 
    | 
    | It is critical that you append your view's package name with "::"! 
    |
    */
    'what_package_are_the_view_files' => 'lasallesoftwarecontactform::',

    /*
    |--------------------------------------------------------------------------
    | Where Is The Base Layout?
    |--------------------------------------------------------------------------
    |
    | This content form package's view files extend a base layout. 
    |  
    | The command in the blade files is:
    | @extends('lasallesoftwarelasalleui::base.layouts.baselayout')
    | 
    | Instead of hard coding the location of this base layout, I created this
    | config parameter so we can use our own base layout with the views provided
    | in the package. 
    |
    | So, we can use the views in my content form package with our own layout. 
    | 
    | It is critical that you use the full "path". That is, the package name 
    | and the path to the layout using dot notation.
    |
    */    
    'where_is_the_base_layout' => 'lasallesoftwarelasalleui::base.layouts.baselayout',

];