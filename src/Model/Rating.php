<?php

namespace App\Model;

class Rating {
    private int $id;
    private int $userId;
    private int $recipeId;
    private int $rating;
    private ?string $comment;
    private string $createdAt;

    public function __construct(int $userId, int $recipeId, int $rating, ?string $comment = null) {
        $this->userId = $userId;
        $this->recipeId = $recipeId;
        if ($rating < 1 || $rating > 5) {
            throw new \InvalidArgumentException('Rating must be between 1 and 5');
        }
        $this->rating = $rating;
        $this->comment = $comment;
        $this->createdAt = date('Y-m-d H:i:s');
    }

    // Getters and setters
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

    public function getRating(): int {
        return $this->rating;
    }

    public function getComment(): ?string {
        return $this->comment;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }
}