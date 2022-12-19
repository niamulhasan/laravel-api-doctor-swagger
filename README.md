# API Doctor Swagger for Laravel (Auto Generator)
A swagger OpenApi Documentation generator for laravel. This package **requires no phpDoc comments**
<p align="left"> <img src="https://komarev.com/ghpvc/?username=laravel-api-doctor-swagger&label=Views&color=0e75b6&style=flat" alt="niamulhasan" /> </p>

## About 
All other swagger packages require you to write phpDoc comments. This package is different. It will generate swagger documentation from your routes and controllers.

## Installation
### Step 1: Add the package repository to your composer.json file
In your projects `composer.json` file,add the following "repositories" section:
```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/niamulhasan/laravel-api-doctor-swagger"
    }
]
```

Example:
```json
{
    "name": "laravel/laravel",
    "description": "The Laravel Framework.",
    "keywords": ["framework", "laravel"],
    "license": "MIT",
    "type": "project",
    //Here is the section
    "repositories": [
      {
        "type": "vcs",
        "url": "https://github.com/niamulhasan/laravel-api-doctor-swagger"
      }
    ],
    "require": {
        "php": "^7.2.5",
        "fideloper/proxy": "^4.0"
    },
    ...
    ...
        
}
```
### Step 2: Install the package
Then run the following command to install the package:
```bash
composer require niamulhasan/api-doctor-swagger
```
### Edit your `config/app.php` file
Add the following line to the `providers` array:
```php
Niamulhasan\ApiDoctorSwagger\ApiDoctorSwaggerProvider::class,
```
This will register the package's service provider for your project.


## Usage
A new route will be added to your project. You can access the swagger documentation by visiting the following url:
```
http://your-project-url/api-docs
```
And the swagger yaml file will be available at:
```
http://your-project-url/swagger-yaml-file-generated
```

## Conclusion
This package is being developed for my own projects. I will be adding more features to it as I need them. If you have any suggestions or find any bug please feel free to open an issue or a pull request.
