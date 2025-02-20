<?php

namespace App\Core;

use App\Core\Model\Route;
use App\Core\Service\ConfigurationProvider;
use Symfony\Component\Yaml\Yaml;

class Router
{
    private const CONFIG_FILE = '../config/routes.yaml';
    private array $routes;

    public function __construct()
    {
        $this->loadRoutes();
    }

    public function match(string $path)
    {
        //error_log("routes: " . print_r($this->routes, true));
        foreach ($this->routes as $route) {
            $routePath = $route->getPath(); // Get the route path, e.g., "/recette/detail/{id}"
            
            // Check if route contains placeholders (like {id})
            if (strpos($routePath, '{') !== false) {
                error_log("routePath: " . print_r($routePath, true));
                // Convert placeholders like "{id}" to a regex pattern that matches numbers
                // Convert placeholders like "{id}" or "{token}" to a regex pattern that matches alphanumeric characters
                $pattern = preg_replace('/\{(\w+)\}/', '([a-zA-Z0-9]+)', $routePath);
                $pattern = "#^" . $pattern . "$#"; // Ensure full match
    
                if (preg_match($pattern, $path, $matches)) {
                    array_shift($matches); // Remove the full match from $matches
                    $route->params = $matches; // Store extracted parametersgi
                    error_log("params: " . print_r($route->params, true));
                    return $route; // Return the matched route
                }
            } else {
             

                // If no placeholders, check if the path exactly matches
                if ($path === $routePath) {
                    
                    return $route; // Exact match for routes like "/recette/search"
                }
            }
        }
        
        // If no route was matched, return null
        return null; 
    }
    


    private function loadRoutes(): void
    {
        $configProvider = new ConfigurationProvider();
        $arrayRoutes = $configProvider->load(self::CONFIG_FILE);

        foreach ($arrayRoutes as $routeName => $arrayRoute) {
            $this->routes[] = new Route($routeName, $arrayRoute['path'], $arrayRoute['controller']);
        }
    }
}