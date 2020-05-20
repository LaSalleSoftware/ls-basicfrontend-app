# AWS_S3_NOTES_README.md

## Your administrative app's S3 must be set up first!

This front-end app assumes that you are using the blog features. The blog admin is in the admin app. So, you need to install the admin app first. 

The bulk of the S3 set-up is done during the admin app's S3 set-up. For reference, here is the admin app's [S3 set-up](https://github.com/LaSalleSoftware/ls-adminbackend-app/blob/master/AWS_S3_NOTES_README.md).

There are a few things to do specifically for this front-end app...

## Step 1: Double check that you have these dependencies in your composer.json

Yes, I have [these dependencies](https://laravel.com/docs/master/filesystem#driver-prerequisites) in composer.json already. Yes, I am asking you to double check anyways because if something is not working this is the first thing to check. Might as well take a peek now!

Please ensure that these two lines are in your composer.json's require section:

```
"league/flysystem-aws-s3-v3": "~1.0",
"league/flysystem-cached-adapter": "~1.0",
```

## Step 2: Set the config parameter to "s3"

- go to the "config/lasallesoftware-library.php" config file
- scroll down to the "Filesystem Disk Where Images Are Stored" section
- set the parameter to 's3': ```'lasalle_filesystem_disk_where_images_are_stored'  => 's3',```

## Step 3: Assign the new bucket you created in the admin app a new CORS permission for this front-end domain

- log into your AWS console
- click "Services" at the top left
- click "S3" under the "Storage" heading in the rather busy drop-down
- you should see a list of your buckets
- in this list of buckets, click the new bucket you just created in the admin app storage
- you should see the "CORS configuration" button
- please click this "CORS configuration" button
- paste the following into the "CORS configuration editor":

```
<CORSConfiguration>
  <CORSRule>
    <AllowedOrigin>https://yourdomain.com</AllowedOrigin>
    <AllowedMethod>GET</AllowedMethod>
    <AllowedMethod>POST</AllowedMethod>
    <AllowedMethod>DELETE</AllowedMethod>
    <AllowedHeader>*</AllowedHeader> 
  </CORSRule>
</CORSConfiguration>
```

- over-write "https://yourdomain.com" with the domain of this front-end app
- click the "Save" button on the top right of the edit box
- now you should have your previous CORS permissions, and you should have this new one you just created

## Step 4: Enter your new bucket name into your .env's "AWS_BUCKET" parameter

- open a new window with your application's .env file
- paste your new bucket's name to your .env's "AWS_BUCKET" parameter

## Step 5: Enter your .env's "AWS_URL" parameter

The easiest way to do this is to copy the "AWS_URL" environment variable in your admin app's ".env" file, and paste it into this app's ".env" file.

## Step 6: Create a new IAM "API" user specifically for this front-end app

Do not use the same IAM user for this front-end app that your administrative back-end app uses. 

Each app should use its own dedicated IAM user. 

- if not logged in, please log into your AWS console
- click "Services" at the top left
- click "IAM" under the "Security, Identity, & Compliance" heading in the rather busy drop-down
- click "Users" in the left vertical menu, under the "Access management" heading
- click the "Add user" button at the top
- click your new user's name in the "User name*" box
- click the "Programmatic access" check box in the "Access type*" section
- absolutely do NOT, repeat NOT, click the "AWS Management Console access" check box
  ** my attitude is: a user is either "Programmatic access" or "AWS Management Console access", never both
- click the "Next: Permissions" button at the bottom right  
- you should be in the "Set permissions" page
- the new group for these users created during the admin app's S3 set-up should be listed. 
- click the checkmark next to this group
- click the "Next: Tags" button at the bottom right
- you should be in the "Add tags (optional)" page. I generally ignore this page
- click the "Next: Review" button on the bottom right
- you should be on the "Review" page
- your new user's "AWS access type" should say "Programmatic access - with an access key"
- we're good? Ok! Click the "Create user" button on the bottom right
- you should see a "Success" message
- you should see the "Show" link? 
- open a new window and open your application's .env file, if you have yet to do so
- paste the access key ID to your .env's "AWS_ACCESS_KEY_ID" parameter
- click the "Show" link
- paste the secret access key to your .env's "AWS_SECRET_ACCESS_KEY" parameter
- when you leave this page, the secret access key is not accessible, so be careful with this copy-paste
- click the "Close" button at the bottom right

## Step 7: Replicate your admin app's use of S3 folders

- go to your admin app's ```config/lasallesoftware-library.php``` config file
- scroll down to the "PATHS FOR FEATURED IMAGES" section
- go to this front-end app's ```config/lasallesoftware-library.php``` config file
- scroll down to the "PATHS FOR FEATURED IMAGES" section
- make sure the admin app's paths settings are replicated in this front-end app's path settings

***********************************
** end of AWS_S3_NOTES_README.md **
***********************************




