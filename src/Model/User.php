<?php

namespace App\Model;

class User {
    private int $id;
    private string $email;
    private string $password;
    private ?string $confirmationToken;
    private bool $isConfirmed;
    private ?string $resetToken;

    public function __construct(string $email, string $password, ?int $id = null) {
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->confirmationToken = bin2hex(random_bytes(32));
        $this->isConfirmed = false;
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): void
    {
        $this->confirmationToken = $confirmationToken;
    }

    public function isConfirmed(): bool
    {
        return $this->isConfirmed;
    }

    public function setIsConfirmed(bool $isConfirmed): void
    {
        $this->isConfirmed = $isConfirmed;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): void
    {
        $this->resetToken = $resetToken;
    }

}