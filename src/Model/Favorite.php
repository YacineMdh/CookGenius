<?php

namespace App\Model;

class Favorite {
    private int $id;
    private int $userId;
    private int $recipeId;
    private string $createdAt;

    public function __construct(int $userId, int $recipeId) {
        $this->userId = $userId;
        $this->recipeId = $recipeId;
        $this->createdAt = date('Y-m-d H:i:s');
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getRecipeId(): int {
        return $this->recipeId;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }
}