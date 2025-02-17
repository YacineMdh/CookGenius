<?php

namespace App\Service;

use App\Model\Favorite;
use PDO;

class FavoriteService {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = new PDO(
            "pgsql:host=shopxdev.c4sqhgh3gh8j.us-east-1.rds.amazonaws.com;dbname=laravel_ecommerce",
            "laravel_ecom",
            "password"
        );
    }

    public function addFavorite(int $userId, int $recipeId): Favorite {
        // Vérifier si déjà en favori
        if ($this->isFavorite($userId, $recipeId)) {
            throw new \RuntimeException('Recipe already in favorites');
        }

        $favorite = new Favorite($userId, $recipeId);

        $stmt = $this->pdo->prepare(
            "INSERT INTO favorites (user_id, recipe_id, created_at) 
             VALUES (:userId, :recipeId, :createdAt)"
        );

        $stmt->execute([
            'userId' => $favorite->getUserId(),
            'recipeId' => $favorite->getRecipeId(),
            'createdAt' => $favorite->getCreatedAt()
        ]);

        $favorite->setId($this->pdo->lastInsertId());

        return $favorite;
    }

    public function removeFavorite(int $userId, int $recipeId): bool {
        $stmt = $this->pdo->prepare(
            "DELETE FROM favorites 
             WHERE user_id = :userId AND recipe_id = :recipeId"
        );

        return $stmt->execute([
            'userId' => $userId,
            'recipeId' => $recipeId
        ]);
    }

    public function isFavorite(int $userId, int $recipeId): bool {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) as count FROM favorites 
             WHERE user_id = :userId AND recipe_id = :recipeId"
        );

        $stmt->execute([
            'userId' => $userId,
            'recipeId' => $recipeId
        ]);

        return (bool) $stmt->fetch()['count'];
    }

    public function getUserFavorites(int $userId): array {
        $stmt = $this->pdo->prepare(
            "SELECT recipe_id FROM favorites 
             WHERE user_id = :userId 
             ORDER BY created_at DESC"
        );

        $stmt->execute(['userId' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}