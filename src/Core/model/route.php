<?php

namespace App\Core\Model;

class Route
{
    public function __construct(
        private string $name,
        private string $path,
        private string $controller,
        public array $params = []
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getController(): string
    {
        return $this->controller;
    }
}