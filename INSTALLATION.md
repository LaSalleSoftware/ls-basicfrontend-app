# Installing LaSalle Software's Basic Front-end Application

## Your admin app must be installed first!

Your LaSalle Software's administrative app must be installed already!

You will need values in your adminstrative app's .env file, so please open your admin app's .env file.

## Local environment set-up

#### Set up your local site
 
- in your commmand line, run ```composer create-project --prefer-dist lasallesoftware/ls-basicfrontend-app your-custom-frontend-folder``` 
- ```cd your-custom-frontend-folder```
- if you have not yet set up your MAMP/LAMP/DOCKER/VM/etc! site for this app, then please do so now
- if you want to paste one of the composer.xxxxxx.json files into your composer.json, then do so now and run ```composer update``` 
- in your command line, run ```php artisan lslibrary:lasalleinstallenv``` to set some environment variables in your .env file
- open your .env and double-check that the environment settings are ok

If you are using MAMP, your MySQL may not work so you should add the following "DB_SOCKET" variable to your .env:
```
// https://stackoverflow.com/questions/50718944/laravel-5-6-connect-refused-using-mamp-server
DB_SOCKET=/Applications/MAMP/tmp/mysql/mysql.sock
```

- in your command line, run ```php artisan lslibrary:lasalleinstallfrontendapp``` to populate some database tables.
- set the config parameters as appropriate at ```config/lasallesoftware-frontendapp.php```. There are inline comments. 
- make sure your paths, as specified in "config/lasallesoftware-library.php",  are the same as specified in the admin app's "config/lasallesoftware-library.php"

#### Queues

On your local computer, for queuing, most likely, you will want to set the queue connection environment parameter to "sync":
```
QUEUE_CONNECTION=sync
```

## Forge set-up

Since I am using a Forge/Digital Ocean set-up for my production site, I will go through the steps here. 

You can adapt these steps to your particular situation.

I talk of Forge more in my [Admin app's installation guide](https://github.com/LaSalleSoftware/ls-adminbackend-app/blob/master/INSTALLATION.md).

How about [Laravel's Vapor](https://vapor.laravel.com)? Oh yes, I am quite interested in deploying my LaSalle Software with Vapor!

#### Set up your new repository in GitHub

I assume that you are using GitHub, and then deploying your Forge site from GitHub. I assume you know how to set things up in GitHub! 

So, if you have not yet created your new repository for your production site in GitHub, please do so now. 

#### Composer.json

I am assuming that you copied "composer.forge.json" to your "composer.json" in your local front-end app. 

If not, then make sure your "composer.json" in your local front-end app will be ok for production. 

#### Make your local site, done above, a git repo

You know that local site you did above? Well, time to make it a git repo.

- in your command line, ```cd your-custom-frontend-folder```
- ```git init```
- ```git add .```
- ```git commit -m "The initial commit!"```
- ```git remote add origin git@github.com:account-name/repo-name.git```
- ```git push -u origin master``` 

#### Set up your new site in Forge

My admin app's installation guide has more on this. 

Don't forget to create your SSL (LetsEncrypt).

The relatively new [User Isolation feature](https://forge.laravel.com/docs/1.0/sites/user-isolation.html#overview) is interesting!

#### Set up your site's Git Repository

- click "Sites" in the top menu, then your new site in the drop-down
- click "Git Repository"
- you should see the "Install Repository" box
- Provider = GitHub; Repository = your GitHub repo; Branch = master (usually!)

The "Install Repository" box: I un-check "Install Composer Dependencies". 

The default "Deploy Script" will then exclude "composer install", which gives me the option when to run it. And, it will exclude "php artisan migrate --force". Even though there are no migrations, I don't want the weird possibility that the front-end is migrating something to the admin database. The front-end and admin apps use the same database. 

This is the deploy script Forge creates when you check "Install Composer Dependencies":
```
cd /home/forge/site-name
git pull origin master
composer install --no-interaction --prefer-dist --optimize-autoloader

( flock -w 10 9 || exit 1
    echo 'Restarting FPM...'; sudo -S service php7.3-fpm reload ) 9>/tmp/fpmlock

if [ -f artisan ]; then
    php artisan migrate --force
fi
```

This is the deploy script that I want:
```
cd /home/forge/site-name
git pull origin master

( flock -w 10 9 || exit 1
    echo 'Restarting FPM...'; sudo -S service php7.3-fpm reload ) 9>/tmp/fpmlock
```

You are probably ok to check "Install Composer Dependencies", and you are probably ok with the deploy script whence created. 

With all that said, click the "Install Repository" button.

#### SSH into your server to do some command line stuff

- ssh into your server
- ```cd name-of-your-site's-folder```
- if not already performed above, ```composer install --prefer-dist --optimize-autoloader``` (hint: run this if you do not see the vendor folder)
- please open your admin app's ".env" file so you can reference values for the next step
- ```php artisan lslibrary:lasalleinstallenv```

#### Double check your .env

Please look over your .env settings to make sure they are ok.  

Your database settings are probably incorrect because Forge inserts the default db settings. So please make very sure that your .env database settings are correct!

#### Back to the command line!

- ```php artisan lslibrary:lasalleinstallfrontendapp```

#### Troubleshooting

Your site should work. 

Mine did not. I got a "403 forbidden" error". I think it was something to do with the Opcache. So I restarted my server, which did the trick:
- click "Servers" in the top menu
- click your server in the drop-down
- scroll to the bottom of the page
- click the "Restart" button at the bottom right
- click "Restart Server" in the drop-down (drop-up???)

## Using Cloud Storage

In production, you should use cloud storage for your images, especially when you are using multiple domains. See this app's [AWS S3 notes](AWS_S3_NOTES_README.md).
