<?php

namespace App\Controller;

use App\Core\Service\ViewManager;
use App\Service\SpoonacularAPI;

class HomeController {

    private $api;
    private $viewManager;

    public function __construct() {
        $this->api = new SpoonacularAPI();
        $this->viewManager = new ViewManager();
    }

    public function index() {
        // Start the session if it's not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the random and common recipes data are already in the session
        if (!isset($_SESSION['randomRecipes']) || !isset($_SESSION['commonRecipes'])) {
            // Data is not in the session, so fetch it from the API
            $randomRecipes = $this->api->getRandomRecipes(5);
            $commonRecipes = $this->api->getMostCommonRecipes();

            // Store the fetched data in the session
            $_SESSION['randomRecipes'] = $randomRecipes;
            $_SESSION['commonRecipes'] = $commonRecipes;
        } else {
            // Use the data from the session if it's already set
            $randomRecipes = $_SESSION['randomRecipes'];
            $commonRecipes = $_SESSION['commonRecipes'];
        }

        // Pass data to the view and render it
        $this->viewManager->render('home', [
            'randomRecipes' => $randomRecipes,   // Pass the random recipes
            'commonRecipes' => $commonRecipes    // Pass the common recipes
        ]);
    }
}
