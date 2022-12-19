<?php


namespace NiamulHasan\ApiDoctorSwagger\ApiDoctor;


class ApiDoctorSwaggerSections
{
    public static function getTags($entities): array
    {
        $tags = [];
        foreach ($entities as $entity) {
            $tags[] = [
                'name' => $entity,
                'description' => $entity . ' entity',
            ];
        }
        return $tags;
    }

    public static function buildSwaggerRoutes($routes)
    {
        $result = "";
        foreach ($routes as $route) {
            $uri = '/' . $route->uri;
            $tag = ApiDoctorHelper::getTag($route);
            $entity = ApiDoctorHelper::getEntity($tag);
            $method = strtolower($route->methods[0]);

            $parameters_section = self::buildParameters(ApiDoctorHelper::getParameters($route));

            $parameters = "";
            if ($parameters_section != "") {
                $parameters = "
       parameters:
                {$parameters_section}
            ";
            }


            $routeString = "
   {$uri}:
     {$method}:
       tags:
         - {$entity}
       summary: {$entity}
       {$parameters}
       description: '{$entity}'
       operationId: {$tag}
       consumes:
         - application/json
       produces:
         - application/json
       responses:
         '200':
           description: successful operation
         '400':
           description: Bad request
         ";
            $result .= $routeString;
        }
        return $result;
    }

    //build swagger tags section yaml string
    public static function buildSwaggerTags($tags): string
    {
        $result = "";
        foreach ($tags as $tag) {
            $tagString = "
   - name: {$tag['name']}
     description: {$tag['description']}
         ";
            $result .= $tagString;
        }
        return $result;
    }

    public static function buildParameters($parameters)
    {
        $result = "";
        $isObject = true;
        foreach ($parameters as $parameter => $type) {
            if ($type == 'int') {
                $type = 'integer';
                $isObject = false;
            } else if ($type == 'bool') {
                $type = 'boolean';
                $isObject = false;
            } else if ($type == 'array') {
                $type = 'array';
                $isObject = false;
            } else if ($type == 'string') {
                $type = 'string';
                $isObject = false;
            } else if ($type == 'float') {
                $type = 'number';
                $isObject = false;
            } else if ($type == 'double') {
                $type = 'number';
                $isObject = false;
            } else if ($type == 'object') {
                $type = 'object';
                $isObject = false;
            }

            $in = $isObject ? 'body' : 'path';

            $rules = array();

            if ($isObject) {
                //replace the word 'App' with 'app'
                $type = str_replace('App', 'app', $type);
                //replace "\" with "/"
                $type = str_replace('\\', '/', $type);

                $file = file_get_contents(base_path($type . '.php'));

                //extract the content of rules method
                preg_match('/rules\(\)(.*?)}/s', $file, $matches);
                //extract the content after 'return' keyword
                preg_match('/return(.*?)\;/s', $matches[0], $matches);

                //create an associative array, where content before '=>' is the key and content after '=>' is the value
                preg_match_all('/\'(.*?)\'\s*=>\s*\'(.*?)\'/', $matches[0], $matches);
                foreach ($matches[1] as $key => $value) {
                    $rules[$value] = $matches[2][$key];
                }
            }

            $schema = "";
            //if array is not empty build schema properties section
            if (!empty($rules)) {
                $properties = self::buildProperties($rules);

                $description = "";
                foreach ($rules as $key => $value) {
                    $description .= "=> " . $key . " - " . $value . "      ";
                }

                $schema = "
           description: {$description}
           schema:
               type: object
               properties:
                   {$properties}
                ";
            }

            $parameterString = "
         - name: {$parameter}
           in: {$in}
           type: {$type}
{$schema}
           ";
            $result .= $parameterString;
        }
        return $result;
    }


    public static function buildProperties($rules)
    {
        $result = "";
        foreach ($rules as $rule => $value) {
            preg_match('/(.*?)\|/', $value, $matches);
            $type = $matches[1];
            $propertyString = "
                   {$rule}:
                       type: string
                       description: {$value}
           ";
            $result .= $propertyString;
        }
        return $result;
    }
}
