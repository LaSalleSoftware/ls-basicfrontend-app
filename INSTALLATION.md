# Installing LaSalle Software's Basic Front-end Application

## The intention with the front-end is to not install a database

The intention of this front-end app is to not install a database. 

This front-end app is supposed to consume data from the administrative app. 

If there is a need to have a separate independent database for this front-end app, then that is something different. Please be mindful that the trend is very much going away from monolithic architectures. 

## This installation guide references my Admin App's Install Guide

In general, please refer to my [Admin app's installation guide](https://github.com/LaSalleSoftware/lsv2-adminbackend-app/blob/master/INSTALLATION.md) as reference. 

## Local environment set-up

#### Set up your local site

Run the following command in the command line. Specify your specific folder where the front-end app will reside. 

```composer create-project lasallesoftware/lsv2-basicfrontend-app lsv2-basicfrontend-app```

#### If you are setting up this local admin app for production, then change the composer.json

Generally, but especially when you are using Forge for production deployments, paste "composer.forge.json" to your composer.json.

Then run ```composer update```

#### Run lslibrary:lasalleinstallenv

Run my custom installation artisan command for setting a few environment variables in your .env file:

```php artisan lslibrary:lasalleinstallenv```

"lasalleinstallenv" = a kind of a short form of "LaSalle Installation for Environment Variables". Well, only a few env vars.

#### Edit your local .env file

At this point, please review your local .env file. 

If APP_KEY is blank, then run ```php artisan key:generate``` to generate the [application key](https://laravel.com/docs/6.x#configuration)

Now save your modified local .env file.

## Deploying on Laravel Forge

Except for the database stuff, it's pretty well the same steps as the admin app. 

## Config file at app/lasallesoftware-frontendapp.php

Set the config parameters as appropriate at ```app/lasallesoftware-frontendapp.php```. There are inline comments. 

## Using Cloud Storage

In production, you should use cloud storage for your images, especially when you are using multiple domains. See this app's [AWS S3 notes](AWS_S3_NOTES_README.md).