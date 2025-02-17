<?php

namespace App\Service;

use App\Model\Rating;
use PDO;

class RatingService {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = new PDO(
            "pgsql:host=shopxdev.c4sqhgh3gh8j.us-east-1.rds.amazonaws.com;dbname=laravel_ecommerce",
            "laravel_ecom",
            "password"
        );
    }

    public function addRating(Rating $rating): Rating {
        // Vérifier si l'utilisateur a déjà noté cette recette
        $existingRating = $this->getUserRating($rating->getUserId(), $rating->getRecipeId());

        if ($existingRating) {
            // Mise à jour de la note existante
            $stmt = $this->pdo->prepare(
                "UPDATE ratings 
                 SET rating = :rating, comment = :comment, updated_at = NOW() 
                 WHERE user_id = :userId AND recipe_id = :recipeId"
            );
        } else {
            // Nouvelle note
            $stmt = $this->pdo->prepare(
                "INSERT INTO ratings (user_id, recipe_id, rating, comment, created_at) 
                 VALUES (:userId, :recipeId, :rating, :comment, :createdAt)"
            );
        }

        $stmt->execute([
            'userId' => $rating->getUserId(),
            'recipeId' => $rating->getRecipeId(),
            'rating' => $rating->getRating(),
            'comment' => $rating->getComment(),
            'createdAt' => $rating->getCreatedAt()
        ]);

        if (!$existingRating) {
            $rating->setId($this->pdo->lastInsertId());
        }

        return $rating;
    }

    public function getUserRating(int $userId, int $recipeId): ?Rating {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM ratings 
             WHERE user_id = :userId AND recipe_id = :recipeId"
        );

        $stmt->execute([
            'userId' => $userId,
            'recipeId' => $recipeId
        ]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }

        $rating = new Rating(
            $data['user_id'],
            $data['recipe_id'],
            $data['rating'],
            $data['comment']
        );
        $rating->setId($data['id']);

        return $rating;
    }

    public function getRecipeRatings(int $recipeId): array {
        $stmt = $this->pdo->prepare(
            "SELECT r.*, u.firstname, u.lastname 
             FROM ratings r 
             JOIN users u ON r.user_id = u.id 
             WHERE r.recipe_id = :recipeId 
             ORDER BY r.created_at DESC"
        );

        $stmt->execute(['recipeId' => $recipeId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAverageRating(int $recipeId): array {
        $stmt = $this->pdo->prepare(
            "SELECT 
                AVG(rating) as average,
                COUNT(*) as total,
                COUNT(CASE WHEN rating = 5 THEN 1 END) as five_stars,
                COUNT(CASE WHEN rating = 4 THEN 1 END) as four_stars,
                COUNT(CASE WHEN rating = 3 THEN 1 END) as three_stars,
                COUNT(CASE WHEN rating = 2 THEN 1 END) as two_stars,
                COUNT(CASE WHEN rating = 1 THEN 1 END) as one_star
             FROM ratings 
             WHERE recipe_id = :recipeId"
        );

        $stmt->execute(['recipeId' => $recipeId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}