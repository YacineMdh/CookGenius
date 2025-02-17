<?php

namespace App\Core;

use App\Core\Router;
use App\Middleware\AuthenticationMiddleware;


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

        $authMiddleware = new AuthenticationMiddleware();
        $authMiddleware->handle();

        $router = new Router();
        $route = $router->match($path);
        error_log("route: " . print_r($path, true));
        
        $controllerFragments = explode('::', $route->getController());
        $controllerClass = $controllerFragments[0];
        $controllerMethod = $controllerFragments[1];
        
        $controller = new $controllerClass();
        
        // ✅ Pass extracted parameters from $route->getParams()
        call_user_func_array([$controller, $controllerMethod], $route->params // ✅ Correct: it's a property
    );
        
    }
}