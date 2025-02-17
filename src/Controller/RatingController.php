<?php

namespace App\Controller;

use App\Service\RatingService;
use App\Model\Rating;

class RatingController
{
    private RatingService $ratingService;

    public function __construct()
    {
        $this->ratingService = new RatingService();
    }

    public function submitRating(): void
    {
        try {
            // Vérification de l'authentification
            if (!isset($_SESSION['user_id'])) {
                $_SESSION['error'] = 'You must be logged in to rate recipes';
                header('Location: /login');
                exit;
            }

            // Validation des données
            if (!isset($_POST['recipe_id'], $_POST['rating'])) {
                throw new \InvalidArgumentException('Missing required fields');
            }

            $recipeId = (int) $_POST['recipe_id'];
            $rating = (int) $_POST['rating'];
            $comment = $_POST['comment'] ?? '';
            $userId = (int) $_SESSION['user_id'];

            // Validation du score
            if ($rating < 1 || $rating > 5) {
                throw new \InvalidArgumentException('Rating must be between 1 and 5');
            }

            // Validation du commentaire
            if (strlen($comment) > 1000) {
                throw new \InvalidArgumentException('Comment is too long (maximum 1000 characters)');
            }

            // Création de l'objet Rating
            $ratingObj = new Rating($userId, $recipeId, $rating, $comment);

            // Sauvegarde de la notation
            $this->ratingService->addRating($ratingObj);

            // Message de succès
            $_SESSION['success'] = 'Your review has been submitted successfully!';

        } catch (\InvalidArgumentException $e) {
            $_SESSION['error'] = $e->getMessage();
        } catch (\Exception $e) {
            error_log('Error submitting rating: ' . $e->getMessage());
            $_SESSION['error'] = 'An error occurred while submitting your review. Please try again.';
        }

        // Redirection vers la page de la recette
        header('Location: /recette/detail/' . $recipeId);
        exit;
    }

    public function deleteRating(): void
    {
        try {
            // Vérification de l'authentification
            if (!isset($_SESSION['user_id'])) {
                $_SESSION['error'] = 'You must be logged in to manage reviews';
                header('Location: /login');
                exit;
            }

            if (!isset($_POST['recipe_id'])) {
                throw new \InvalidArgumentException('Recipe ID is required');
            }

            $recipeId = (int) $_POST['recipe_id'];
            $userId = (int) $_SESSION['user_id'];

            // Vérification que la notation existe et appartient à l'utilisateur
            $rating = $this->ratingService->getUserRating($userId, $recipeId);
            if (!$rating) {
                throw new \InvalidArgumentException('Rating not found');
            }

            // Suppression de la notation
            $this->ratingService->deleteRating($userId, $recipeId);

            $_SESSION['success'] = 'Your review has been deleted successfully.';

        } catch (\InvalidArgumentException $e) {
            $_SESSION['error'] = $e->getMessage();
        } catch (\Exception $e) {
            error_log('Error deleting rating: ' . $e->getMessage());
            $_SESSION['error'] = 'An error occurred while deleting your review. Please try again.';
        }

        // Redirection vers la page de la recette
        header('Location: /recipe/' . $recipeId);
        exit;
    }

    public function getRatings(int $recipeId): array
    {
        try {
            return [
                'ratings' => $this->ratingService->getRecipeRatings($recipeId),
                'stats' => $this->ratingService->getAverageRating($recipeId)
            ];
        } catch (\Exception $e) {
            error_log('Error fetching ratings: ' . $e->getMessage());
            return [
                'ratings' => [],
                'stats' => [
                    'average' => 0,
                    'total' => 0,
                    'five_stars' => 0,
                    'four_stars' => 0,
                    'three_stars' => 0,
                    'two_stars' => 0,
                    'one_star' => 0
                ]
            ];
        }
    }

    public function getUserRating(int $recipeId): ?Rating
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        try {
            return $this->ratingService->getUserRating(
                (int) $_SESSION['user_id'],
                $recipeId
            );
        } catch (\Exception $e) {
            error_log('Error fetching user rating: ' . $e->getMessage());
            return null;
        }
    }
}