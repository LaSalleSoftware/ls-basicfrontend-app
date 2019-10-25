AWS_S3_NOTES_README.md


If you have a front-end and a back-end for your blog (or whatever else), then your images (and whatever else) have to be on a server that both ends can access. Meaning, using The Cloud. Which means, S3, right?!

Both your front-end and your back-end need The League of Extraordinary Packages' S3 package (https://github.com/thephpleague/flysystem-aws-s3-v3). The require statement should already be in your composer.json, but here is the line:

```
"require": {
        ...
        "league/flysystem-aws-s3-v3": "^1.0",
        ...
    },
```

Set up your S3 bucket as usual in S3. 

You need to disable "Block all public access":
 * go to your bucket in the AWS S3 console
 * Permissions
 * Block public access
 * Edit
 * uncheck "Block all public access"
 * Save
 * click "Bucket Policy"
 * paste the following code and save (reminder: modify the bucket name, eh!):
 
 ```
 {
     "Version": "2012-10-17",
     "Statement": [
         {
             "Sid": "PublicReadGetObject",
             "Effect": "Allow",
             "Principal": "*",
             "Action": "s3:GetObject",
             "Resource": "arn:aws:s3:::your-bucket-name-goes-here-eh!/*"
         }
     ]
 }
```

Now, you need to create an IAM user with programmatic access only to your bucket. Create a group for the policy, then the policy. Then, create the user, assigning the group to this user. 
 
 Use this JSON for the group's policy (reminder: modify the bucket name, eh!):
 
 ```
 {
     "Version": "2012-10-17",
     "Statement": [
         {
             "Sid": "VisualEditor0",
             "Effect": "Allow",
             "Action": [
                 "s3:ListBucket",
                 "s3:GetBucketLocation"
             ],
             "Resource": "arn:aws:s3:::your-bucket-name-goes-here-eh!"
         },
         {
             "Sid": "VisualEditor1",
             "Effect": "Allow",
             "Action": [
                 "s3:PutObject",
                 "s3:GetObject",
                 "s3:DeleteObject"
             ],
             "Resource": "arn:aws:s3:::your-bucket-name-goes-here-eh!/*"
         },
         {
             "Sid": "VisualEditor2",
             "Effect": "Allow",
             "Action": "s3:ListAllMyBuckets",
             "Resource": "*"
         }
     ]
 }
```
 
The Amazon warnings are dire about making buckets public. Rightly so. Create a bucket solely for the purpose of storing images for your front and back ends. For example, do not store your images that you display to the public in the same bucket as you store your database backups!


 
