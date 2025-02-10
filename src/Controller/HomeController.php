<?php

namespace App\Controller;

use App\Core\Model\SpoonacularAPI;
use App\Core\Service\ViewManager;

class HomeController {

    private $api;
    private $viewManager;

    public function __construct() {
        $this->api = new SpoonacularAPI();
        $this->viewManager = new ViewManager();
    }

    public function index() {
        // Get random recipes and most common recipes
        $randomRecipes = $this->api->getRandomRecipes(5);
        $commonRecipes = $this->api->getMostCommonRecipes();




        // Pass data to the view and render it
        $this->viewManager->render('home', [
            'randomRecipes' => $randomRecipes,   // Pass the random recipes
            'commonRecipes' => $commonRecipes    // Pass the common recipes
        ]);
        
    }
}
