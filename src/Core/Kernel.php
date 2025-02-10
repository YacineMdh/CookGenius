<?php

namespace App\Core;

use App\Core\Router;


class Kernel
{
    public function __construct()
    {
    
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
    }

    public function run(): void
    {
        $path = $_SERVER['PATH_INFO'] ?? '/';

        $router = new Router();
        $route = $router->match($path);
        var_dump($route);
        $controllerFragments = explode('::', $route->getController());
        $controllerClass = $controllerFragments[0];
        $controllerMethod = $controllerFragments[1];

        $controller = new $controllerClass();
        $controller->$controllerMethod();
    }
}