<?php
namespace App\Controller;

use App\Core\Service\ViewManager;
use App\Service\SpoonacularAPI;

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

    public function genererPlanAlimentaire() {
        $suggestions = [];
        $totalCalories = $mealsCount = null;  // Initialize variables
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Check if the POST variables are set
            if (isset($_POST['calories']) && isset($_POST['meals'])) {
                $totalCalories = $_POST['calories'];
                $mealsCount = $_POST['meals'];
    
                // Validate that calories and meals count are positive values
                if ($totalCalories > 0 && $mealsCount > 0) {
                    $caloriesPerMeal = $totalCalories / $mealsCount;
                    $minCalories = $caloriesPerMeal - 100;
                    $maxCalories = $caloriesPerMeal + 100;
    
                    // Fetch available meals from the API
                    $availableMeals = $this->api->rechercherRepasParCalories($minCalories, $maxCalories, 10); // Pass max number of recipes to fetch
    
                    // Check if there are enough meals and slice accordingly
                    if (count($availableMeals) >= $mealsCount) {
                        $suggestions = array_slice($availableMeals, 0, $mealsCount);
                    } else {
                      
                        $suggestions = $availableMeals;
                    }
                } else {
                    $errorMessage = "Calories and meals count must be greater than 0.";
                }
            } else {
  
                $errorMessage = "Please provide both total calories and number of meals.";
            }
        }
    
      
        $this->viewManager->render('health', [
            'suggestions' => $suggestions,
            'calories' => $totalCalories,
            'errorMessage' => $errorMessage ?? null 
        ]);
    }
    
    
    
}
