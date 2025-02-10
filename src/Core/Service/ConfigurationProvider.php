<?php

namespace App\Core\Service;

use Symfony\Component\Yaml\Yaml;


class ConfigurationProvider
{
    private const CONFIG_PATH = '../config/';

    public function load(string $configFile): array
    {
        $path = self::CONFIG_PATH . $configFile;

        if (!file_exists($path)) {
            throw new \Exception('Configuration file not found');
        }

        return Yaml::parseFile($path);
    }
}