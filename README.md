# Laravel Swagger API Doc Generator - API Doctor.
A swagger OpenApi Documentation auto generator for laravel. This package **requires no phpDoc or any kind of comments**
<p align="left"> <img src="https://komarev.com/ghpvc/?username=laravel-api-doctor-swagger&label=Views&color=0e75b6&style=flat" alt="niamulhasan" /> </p>

## Motivation
When I was trying to generate swagger documentation for my laravel project, I found that all the available packages require you to write phpDoc or other form of comments. 
I didn't want to write comments for all my routes and controllers. as it is time-consuming and I am lazy. And the documentation gets outdated very quickly creating a maintenance headache and a source of inconsistency. 
So I decided to create a package that will generate the swagger documentation from the routes and controllers automatically without any form of comments. 

## Features
- Generates swagger documentation automatically from the routes and controllers.
- No need to write phpDoc or any other form of comments.
- Generates documentation for URL parameters.
- Generates documentation for Request body using the `Form Request` type.

## Limitations
- Currently, response documentation is not generated.
- File upload and multipart form data are not supported. 


## Installation
### Step 1: Add these lines to your .env file
```
SWAGGER_VERSION=2.0
```
### Step 2: Add the package repository to your composer.json file
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

### Step 3: Set the minimum stability 
Set the `"minimum-stability": "dev"` in composer.json

### Step 4: Install the package
Then run the following command to install the package:
```bash
composer require niamulhasan/api-doctor-swagger
```
### Step: 5 Add the provider
Add the following line to the `providers` array:
```php
NiamulHasan\ApiDoctorSwagger\Providers\ApiDoctorProvider::class,
```

You can find the providers in `config/app.php` file
for Laravel 11 it's in the `bootstrap/providers.php` file.

This will register the package's service provider for your project.

### Step 5: Publish the package's config file
Run the following command to publish the package's config file:
```bash 
php artisan vendor:publish --provider="NiamulHasan\ApiDoctorSwagger\Providers\ApiDoctorProvider"
```

### Step 6: Turn off CSRF protection for the API routes 
If you face csrf_token missmatch issue

    `protected $except = [
        'api/*'
    ];`
add this in your `app/Http/Middleware/VerifyCsrfToken.php` file

#### For Laravel 11: in `bootstrap/app.php` file
add this
```php
$middleware->validateCsrfTokens(except: ['api/*']);
``` 
in middleware
Like this
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->validateCsrfTokens(except: ['api/*']);
})
```



## Usage
For now this package can generate doc only for **URL parameters** and **Request body**. It will not generate doc for **Query parameters**.

To be able to generate doc for Body parameters you must have to use **Form Request** in your controller method.

### Example
In your controller method:
```php
public function filter(CircularFilterRequest $request): array
    {
        return CircularResource::collection(CircularsService::filter($request->job_type, $request->order_by, $request->order, $request->tags))->toArray($request);
    }
```
In your Form Request:
```php
class CircularFilterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'order_by' => 'string|nullable|in:created_at,starting_date,deadline',
            'order' => 'string|nullable|in:asc,desc',
            'job_type' => 'string|nullable|in:gov,non-gov',
            'tags' => 'array|nullable',
        ];
    }
}
```




A new route will be added to your project. You can access the swagger documentation by visiting the following url:
```
http://your-project-url/api-docs
```
And the swagger yaml file will be available at:
```
http://your-project-url/swagger-yaml-file-generated
```

## Conclusion
This package has been developed for our own needs.
I will be adding more features and improvements to it as I need them.
Feel free to open an issue or a pull request for bug fixes or new features. 
