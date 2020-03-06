<?php

/**
 * This file is part of the Lasalle Software contact form front-end package
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
 * @link       https://packagist.org/packages/lasallesoftware/lsv2-contactformfrontend-pkg
 * @link       https://github.com/LaSalleSoftware/lsv2-contactformfrontend-pkg
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
    | Instead of using a hard coded "lasallesoftwarecontactformfrontend" (this package),
    | which means you have to publish the view (blade) files (to your public folder)
    | and then edit them directly -- which you can do if you want -- I want the 
    | ability to do custom contact form views in a custom UI package. 
    | 
    | So I created this config parameter. 
    | 
    | It is critical that you append your view's package name with "::"! 
    |
    */
    'what_package_are_the_view_files' => 'lasallesoftwarecontactformfrontend::',

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

    /*
    |--------------------------------------------------------------------------
    | FROM email address and name
    |--------------------------------------------------------------------------
    |
    | What email address and name is the contact form email from?
    |  
    */    
    'from_email_address' => 'bob.bloom@lasallesoftware.ca',
    'from_name'          => 'LaSalle Software Contact Form',

    /*
    |--------------------------------------------------------------------------
    | SUBJECT of the email
    |--------------------------------------------------------------------------
    |
    | What is the SUBJECT of the outgoing email?
    |
    | This is the "subject" email field
    |  
    */    
    'subject' => 'Contact Form Submission',

    /*
    |--------------------------------------------------------------------------
    | TO email recipients
    |--------------------------------------------------------------------------
    |
    | What email addresses to you want the contact form email sent to?
    |
    | This is the "to" email field
    |
    | Enter an array of email address(es).
    |  
    */    
    'to_recipients' => ['bob.bloom@lasallesoftware.ca'],

    /*
    |--------------------------------------------------------------------------
    | CC email recipients
    |--------------------------------------------------------------------------
    |
    | What email addresses to you want the contact form email sent to as "cc"?
    |
    | This is the "cc" email field
    |
    | Enter an array of email addresses.
    |
    | Can be an empty array.
    |  
    */    
    'cc_recipients' => [],

    /*
    |--------------------------------------------------------------------------
    | BCC email recipients
    |--------------------------------------------------------------------------
    |
    | What email addresses to you want the contact form email sent to as "bcc"?
    |
    | This is the "bcc" email field
    |
    | Enter an array of email addresses.
    |
    | Can be an empty array.
    |  
    */    
    'bcc_recipients' => [],


    /*
    |--------------------------------------------------------------------------
    | Allow emails to send
    |--------------------------------------------------------------------------
    |
    | Of course you want to send the email out to you with the contact form info.
    |
    | On those occassions that you want to suppress the email -- maybe you are testing,
    | maybe there is an email issue to deal with -- here's a setting to make it easy.
    |
    | Probably easier to modify your .env.
    |
    | true or false
    |  
    */    
    'allow_to_send_email' => env('LASALLE_CONTACTFORMFRONTEND_ALLOW_TO_SEND_EMAIL', true),

    /*
    |--------------------------------------------------------------------------
    | Allow database insertions
    |--------------------------------------------------------------------------
    |
    | Of course you want your contact form submissions to show up in the database. And
    | then to enjoy perusing them in your fine Nova back-end!
    |
    | On those occassions that you want to suppress the database insertion -- maybe you are 
    | testing, maybe there is a database issue to deal with -- here's a setting to make it easy.
    |
    | Probably easier to modify your .env.
    |
    | true or false
    |  
    */    
    'allow_database_insertion' => env('LASALLE_CONTACTFORMFRONTEND_ALLOW_DATABASE_INSERTION', true),

];