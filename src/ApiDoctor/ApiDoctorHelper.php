<?php

namespace NiamulHasan\ApiDoctorSwagger\ApiDoctor;
use ReflectionClass;

class ApiDoctorHelper
{
    public static function getEntity($controller)
    {
        $controller = explode('@', $controller)[0];
        $controller = explode('\\', $controller)[count(explode('\\', $controller)) - 1];
        $controller = substr($controller, 0, -10);
        $controller = self::singularify($controller);
        return $controller;
    }

    public static function singularify($word)
    {
        if (substr($word, -2) == 'es') {
            return substr($word, 0, -2) . 'y';
        }
        if (substr($word, -1) == 's') {
            return substr($word, 0, -1);
        }
        return $word;
    }

    public static function getTag($route)
    {
        if (array_key_exists('controller', $route->action)) {
            return $route->action['controller'];
        }
        return "Undefined";
    }

    public static function getParameters($route)
    {
        if (array_key_exists('controller', $route->action)) {
            $controller = $route->action['controller'];

            $class = explode('@', $controller)[0];
            $method = explode('@', $controller)[1];

            $reflection = new ReflectionClass($class);
            $method = $reflection->getMethod($method);
            $parameters_with_type = [];

            foreach ($method->getParameters() as $parameter) {
                $type = $parameter->getType();
                if ($type) {
                    $parameters_with_type[$parameter->getName()] = $type->getName();
                }
            }
            return $parameters_with_type;
        }
        return [];
    }
}
