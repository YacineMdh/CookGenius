<?php

namespace App\Controller;

use App\Core\Service\ViewManager;
class MainController
{
    private ViewManager $viewManager;

    public function __construct()
    {
        $this->viewManager = new ViewManager();
    }


    public function home(): void
    {
        $this->viewManager->render('home', ['name' => 'World']);
        echo 'Hello World!';
    }
}
