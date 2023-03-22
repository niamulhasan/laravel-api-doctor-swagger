# API Doctor Swagger for Laravel (Auto Generator).
A swagger OpenApi Documentation generator for laravel. This package **requires no phpDoc comments**
<p align="left"> <img src="https://komarev.com/ghpvc/?username=laravel-api-doctor-swagger&label=Views&color=0e75b6&style=flat" alt="niamulhasan" /> </p>

## About 
All other swagger packages require you to write phpDoc comments. This package is different. It will generate swagger documentation from your routes and controllers.

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

Set the `"minimum-stability": "dev"` in composer.json

### Step 3: Install the package
Then run the following command to install the package:
```bash
composer require niamulhasan/api-doctor-swagger
```
### Step: 4 Edit your `config/app.php` file
Add the following line to the `providers` array:
```php
NiamulHasan\ApiDoctorSwagger\Providers\ApiDoctorProvider::class,
```
This will register the package's service provider for your project.

### Step 5: Publish the package's config file
Run the following command to publish the package's config file:

### Step 6: If you face csrf_token missmatch issue

    `protected $except = [
        'api/*'
    ];`
add this in your `app/Http/Middleware/VerifyCsrfToken.php`


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
This package is being developed for my own projects. I will be adding more features to it as I need them. If you have any suggestions or find any bug please feel free to open an issue or a pull request.
