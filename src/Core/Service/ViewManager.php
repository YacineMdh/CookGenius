<?php

namespace App\Core\Service;

use LogicException;

class ViewManager
{
    private const CONFIG_FILE = 'views.yaml';
    private array $config;

    public function __construct()
    {
        $configurationProvider = new ConfigurationProvider();
        $this->config = $configurationProvider->load(self::CONFIG_FILE);
    }

    public function render(string $viewPath): void
    {
        $path = sprintf('%s/%s.php', $this->config['directory'], $viewPath);

        if (!file_exists($path)) {
            throw new LogicException(sprintf('View "%s" does not exist', $viewPath));
        }

        require $path;
    }
}