<?php

namespace NiamulHasan\ApiDoctorSwagger;


use NiamulHasan\ApiDoctorSwagger\ApiDoctor\ApiDoctor;
use NiamulHasan\ApiDoctorSwagger\ApiDoctor\ApiDoctorSwaggerSections;

class ApiDoctorSwagger
{
    public function getYaml(): string
    {

        $routes = ApiDoctor::getRoutes();
        $controllers = ApiDoctor::getControllers($routes);
        $entities = ApiDoctor::getEntities($controllers);
        $tags = ApiDoctorSwaggerSections::getTags($entities);

        $tagString = ApiDoctorSwaggerSections::buildSwaggerTags($tags);
        $paths = ApiDoctorSwaggerSections::buildSwaggerRoutes($routes);


//        dd(getModels());

//        dd(getEntities(getControllers(getRoutes())));


        $swagger = [
            'swagger' => env('SWAGGER_VERSION', '2.0'),
            'info' => [
                'title' => env('APP_NAME', 'Laravel Swagger API Documentation'),
                'description' => env('APP_DESCRIPTION', 'Laravel Swagger API Documentation'),
                'version' => env('API_VERSION', '1.0.0'),
            ],
            'host' => env('APP_URL'),
            'schemes' => ['http'],
            'consumes' => ['application/json'],
            'produces' => ['application/json'],
            'paths' => [],
            'definitions' => [],
        ];


        $entity = "
 swagger: '{$swagger['swagger']}'
 info:
   description: {$swagger['info']['description']}
   version: {$swagger['info']['version']}
   title: {$swagger['info']['title']}
 basePath: '/'

 tags:
   {$tagString}

 paths:
    {$paths}



 securityDefinitions:
   api_key:
     type: apiKey
     name: Authorization
     in: header
     ";
        return $entity;
    }
}
