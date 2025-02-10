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

    public function match(string $path): ?Route
    {
        foreach ($this->routes as $route) {
            if ($path === $route->getPath()) {
                return $route;
            }
        }

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