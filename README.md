# AWS-Batch-API
Accessing AWS Batch via API

I have wrote the php script to submit job to AWS Batch using AWS SDK. 

Steps To Run It

1) Install Composer in your machine.
2) Go to your project working directory.
3) Create a json file (composer.json) with following content and save it.
{
    "require": {
        "aws/aws-sdk-php": "^3.98"
    }
}
4) Open command prompt and run below command.
  - composer install
5) Now, Download the AWS Batch API Script and configure it with your AWS key and Secret key. 
