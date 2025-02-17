<?php

namespace App\Controller;

use App\Core\Service\ViewManager;
use App\Service\FavoriteService;
use App\Service\SpoonacularAPI;


class FavoriteController {
    private FavoriteService $favoriteService;
    private SpoonacularAPI $spoonacularAPI;

    private ViewManager $viewManager;

    public function __construct() {
        $this->favoriteService = new FavoriteService();
        $this->spoonacularAPI = new SpoonacularAPI();
        $this->viewManager = new ViewManager();
    }

    public function toggleFavorite(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $recipeId = (int) $_POST['recipe_id'];
        $userId = (int) $_SESSION['user_id'];

        try {
            if ($this->favoriteService->isFavorite($userId, $recipeId)) {
                $this->favoriteService->removeFavorite($userId, $recipeId);
            } else {
                $this->favoriteService->addFavorite($userId, $recipeId);
            }

            // Rediriger vers la page précédente
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } catch (\Exception $e) {
            // Gérer l'erreur
            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function showFavorites(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $favoriteIds = $this->favoriteService->getUserFavorites($_SESSION['user_id']);
        $favoriteRecipes = [];

        foreach ($favoriteIds as $recipeId) {
            $recipe = $this->spoonacularAPI->rechercherRecetteParId($recipeId);
            if ($recipe) {
                $favoriteRecipes[] = $recipe;
            }
        }

        $this->viewManager->render('favorites', [
            'favoriteRecipes' => $favoriteRecipes
        ]);
    }
}