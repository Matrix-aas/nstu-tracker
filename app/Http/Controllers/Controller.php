<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Laravel\Lumen\Routing\Router;

class Controller extends BaseController
{
    /**
     * Add handler from self to router
     * @param Router $router
     * @param string $method
     * @param null|string $uri
     * @param string $controllerMethod
     */
    public static function addToRouter(Router $router, string $method, ?string $uri, string $controllerMethod)
    {
        static $namespace = null;
        static $className = null;

        if ($className == null) {
            try {
                $reflection = new \ReflectionClass(static::class);

                $namespace = $reflection->getNamespaceName();
                $defNamespace = "App\\Http\\Controllers";
                if (strpos($namespace, $defNamespace) !== false) {
                    $namespace = substr($namespace, strlen($defNamespace));
                }

                $className = $reflection->getShortName();
            } catch (\ReflectionException $exception) {
                throw new \RuntimeException("Can't setupRouter on \"" . static::class . "\"", 500);
            }
        }

        $router->group(["prefix" => camel_case($className)], function (Router $router) use ($namespace, $className, $method, $uri, $controllerMethod) {
            $router->$method($uri, $namespace . $className . "@" . $controllerMethod);
        });
    }
}
