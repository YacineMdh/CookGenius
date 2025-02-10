<?php

namespace App\Core\Model;

class SpoonacularAPI {
    private $apiKey = 'c6120d2f1d024f2d9e18374461fcdfb5';  // Your valid API key
    private function fetchData($url) {
        $ch = curl_init();

        // Set the URL and other cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        // Execute the request and store the response
        $response = curl_exec($ch);

        // Check if there was an error with the cURL request
        if ($response === false) {
            echo "cURL Error: " . curl_error($ch);
            return null;
        }

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        return json_decode($response, true);
    }
    // Function to search recipes by ingredients
    public function rechercherRecettes($ingredients, $exclude) {
        $url = "https://api.spoonacular.com/recipes/complexSearch?query=$ingredients&excludeIngredients=$exclude&apiKey=" . $this->apiKey;
        $response = file_get_contents($url);
        return json_decode($response, true)['results'] ?? [];
    }

    // Function to fetch a recipe by ID
    public function rechercherRecetteParId($id) {
        $url = "https://api.spoonacular.com/recipes/{$id}/information?apiKey=" . $this->apiKey;
        // Log the full URL for the API request
        file_put_contents('api_request.log', "Requesting URL: $url\n", FILE_APPEND);

        // Make the API request
        $response = @file_get_contents($url); // Suppress errors to handle manually

        // Log the response for debugging
        if ($response === FALSE) {
            file_put_contents('api_error.log', "Error fetching recipe ID: $id - URL: $url\n", FILE_APPEND);
            return null;  // If API request fails, return null
        }

        // Log the raw API response
        file_put_contents('api_response.log', "Response for ID $id: $response\n", FILE_APPEND);

        // Decode the response to an array
        $data = json_decode($response, true);

        // Check for API errors (e.g., 404 or other issues)
        if (isset($data['status']) && $data['status'] == 'error') {
            file_put_contents('api_error.log', "API Error for recipe ID: $id - Response: $response\n", FILE_APPEND);
            return null;  // If there is an error in the API response, return null
        }

        return $data ?? null;
    }



    public function getRandomRecipes() {
        $url = "https://api.spoonacular.com/recipes/random?number=5&apiKey=" . $this->apiKey;;
        return $this->fetchData($url)['recipes'] ?? [];
    }
    
    public function getMostCommonRecipes() {
        // Example: Predefined list of popular recipes
        $popularIds = [715538, 716429, 782601, 715497, 715594]; 
        $ids = implode(',', $popularIds);
        $url = "https://api.spoonacular.com/recipes/informationBulk?ids=$ids&apiKey=" . $this->apiKey;;
        return $this->fetchData($url) ?? [];
    }
    
}
