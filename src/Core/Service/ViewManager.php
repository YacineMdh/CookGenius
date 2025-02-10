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

    /**
     * Render the view template with data.
     *
     * @param string $viewPath The path to the view file (without .php extension)
     * @param array $data Associative array of variables to pass to the view
     */
    public function render(string $viewPath, array $data = []): void
    {
        // Construct the full path to the view file
        $path = sprintf('%s/%s.php', $this->config['directory'], $viewPath);

        // Check if the view file exists
        if (!file_exists($path)) {
            throw new LogicException(sprintf('View "%s" does not exist', $viewPath));
        }

        // Extract the data array to individual variables
        extract($data);

        // Include the view file
        require $path;
    }
}
