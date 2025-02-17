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

    public function render(string $viewPath, array $params = []): void
    {
        error_log("base: " . print_r(
                sprintf('%s/base.php', $this->config['directory'])
                , true));
        // Extract parameters to make them available in the view
        extract($params);

        // Start output buffering
        ob_start();

        $viewFile = sprintf('%s/%s.php', $this->config['directory'], $viewPath);

        if (!file_exists($viewFile)) {
            throw new LogicException(sprintf('View "%s" does not exist', $viewPath));
        }

        // Include the view file - its output will be buffered
        require $viewFile;

        // Get the content and clean the buffer
        $content = ob_get_clean();

        // Get the base layout path
        error_log("base: " . print_r(
            sprintf('%s/base.php', $this->config['directory'])
            , true));
        $layoutFile = sprintf('%s/base.php', $this->config['directory']);

        if (!file_exists($layoutFile)) {
            throw new LogicException('Base layout does not exist');
        }

        // Include the base layout which will use $content
        require $layoutFile;
    }
}