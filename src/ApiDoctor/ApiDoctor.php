<?php

namespace NiamulHasan\ApiDoctorSwagger\ApiDoctor;

use Illuminate\Support\Facades\Route;

class ApiDoctor
{
    public static function getRoutes(): array
    {

        $apiRoutes = [];
        $routes = Route::getRoutes()->getRoutes();
        //check if $route from $routes contains $route->action['middleware'] if yes then check if $route->action['middleware'] contains 'api' if yes then add $route to $apiRoutes
        foreach ($routes as $route) {
            if (array_key_exists('middleware', $route->action)) {
                if (in_array('api', $route->action['middleware'])) {
                    $apiRoutes[] = $route;
                }
            }
        }

        return $apiRoutes;
    }

    public static function getControllers($routes): array
    {
        $controllers = [];
        foreach ($routes as $route) {
            if (array_key_exists('controller', $route->action)) {
                $controllers [] = $route->action['controller'];
            }
        }
        return array_unique($controllers);
    }

    public static function getEntities($controllers): array
    {
        $entities = [];
        foreach ($controllers as $controller) {
            $controller = explode('@', $controller)[0];
            $controller = explode('\\', $controller)[count(explode('\\', $controller)) - 1];
            $controller = substr($controller, 0, -10);
            //convert the word to singular if its plural
            $controller = ApiDoctorHelper::singularify($controller);
            $entities [] = $controller;
        }
        return array_unique($entities);
    }

    public static function getModels()
    {
        return array_values(array_filter(array_map(function ($model) {
            return substr($model, 0, -4);
        }, array_diff(scandir(app_path('Models')), array('..', '.'))), function ($model) {
            return !preg_match('/[A-Z]/', substr($model, 1));
        }));
    }


}
