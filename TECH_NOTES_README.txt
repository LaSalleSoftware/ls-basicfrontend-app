A few tech notes...

My goal is to leave the app -- laravel/laravel -- alone. Well, except for adding stuff in the root folder, modifying composer.json, and adding testing files, the actual app itself I want to leave in its original state. 

Reasons:
 * for LaSalle Software Version 1.0, I found it to be a real PITA merging laravel/laravel upgrades into my apps
 * LaSalle Software v2 is essentially a suite of Laravel packages
 
Well, I am authoring a suite of web applications, not strictly a suite of Laravel packages. So there is no getting around that I have to mess with the app itself. So practically speaking, my aim is to have a very light touch modifying laravel/laravel for LaSalle Software v2.

I want a nice simple place to note the things I am doing with Laravel/Laravel. Hence, this file. 

Mods to laravel/laravel:
* create new files in the root folder
* customize composer.json
* add LASALLE_APP_NAME to .env
* customize .env
* add new files to the /tests/ folder
* delete the user and password_reset migrations, now in the library package
* delete the database seed file (which was blank)
* delete the UserFactory, now in the library package
* delete user App\User model, now in the library package,
  at Lasallesoftware\Library\Authentication\Models\User


Misc notes:
* changes to the /config/ files are done within the LaSalle Software packages (see the service provider classes)
  ==> EXCEPT DIRECT EDITS IN config/auth.php (WHICH ARE MARKED)
  ==> EXCEPT A DIRECT EDIT IN config/app.php (WHICH IS MARKED)
* "php artisan db:seed" does *not* run the package database seeders. So, I created a custom artisan command to run them. The command is "php artisan lslibrary:customseed". This artisan command is very handy during testing!
* migration:
  ** when in production, migration files will execute for the admin package only
  ** when in production, migration files will not execute for other, non-admin packages
  ** when in production, and when testing, migration files will not execute
  ** migration will execute in all other environments
  ** see:
     *** Lasallesoftware\Library\Database\Migrations\BaseMigration
     *** Tests\Unit\Library\Database\BaseMigrationTest


 
