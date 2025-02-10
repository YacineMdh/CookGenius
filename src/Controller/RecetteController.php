<?php
namespace App\Controller;

use App\Core\Model\SpoonacularAPI;
use App\Core\Service\ViewManager;

class RecetteController {

    private $api;
    private $viewManager;

    public function __construct() {
        $this->api = new SpoonacularAPI(); // Initialize the API
        $this->viewManager = new ViewManager(); // Initialize the view manager
    }

    // Method to handle the recipe search
    public function rechercheRecette() {
        $recettes = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $ingredients = $_POST['ingredients'] ?? ''; // Get the ingredients from the form
            $ingredients = trim($ingredients); // Remove any extra spaces
            $exclude = $_POST['exclude'] ?? ''; // Get excluded ingredients if any

            // Call the API to search for recipes based on provided ingredients and exclusions
            $recettes = $this->api->rechercherRecettes($ingredients, $exclude);
        }

        // Render the search view and pass the recipes data to it
        $this->viewManager->render('recherche', [
            'recettes' => $recettes
        ]);
    }

    // Method to display the details of a specific recipe
    public function detailRecette($id) {
        // Fetch the recipe details using the Spoonacular API
        $recetteDetails = $this->api->rechercherRecetteParId($id);
    
        // If the recipe is found, render the details view
        if ($recetteDetails) {
            $this->viewManager->render('detail', [
                'recetteDetails' => $recetteDetails
            ]);
        } else {
            // If the recipe is not found, show an error message
            echo "Recipe not found for ID: $id. Please check the API logs for more details.";
        }
    }
    
}
