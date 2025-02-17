<?php

namespace App\Service;

use App\Model\User;
use PDO;

class AuthenticationService {
    private PDO $pdo;

    public function __construct() {
     
        $this->pdo = new PDO(
            "pgsql:host=shopxdev.c4sqhgh3gh8j.us-east-1.rds.amazonaws.com;dbname=laravel_ecommerce",
            "laravel_ecom",
            "password"
        );
    }

    public function register(string $email, string $password): User {
        $user = new User($email, $password);

        $stmt = $this->pdo->prepare(
            "INSERT INTO users (email, password, confirmation_token, is_confirmed) 
         VALUES (:email, :password, :token, false)"
        );

        $stmt->execute([
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'token' => $user->getConfirmationToken()
        ]);

        return $user;
    }

    public function login(string $email, string $password): ?User {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email AND is_confirmed = true");
        $stmt->execute(['email' => $email]);

        if ($user = $stmt->fetch()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                error_log("Debug: " . print_r($_SESSION['user_id'] , true));
                return new User($user['email'], $user['password'],$user['id']);
            }
        }
        return null;
    }

    public function confirmAccount(string $token): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE users SET is_confirmed = true 
             WHERE confirmation_token = :token"
        );
        return $stmt->execute(['token' => $token]);
    }

    public function requestPasswordReset(string $email): bool {
        $token = bin2hex(random_bytes(32));
        $stmt = $this->pdo->prepare(
            "UPDATE users SET reset_token = :token 
             WHERE email = :email"
        );
        return $stmt->execute([
            'token' => $token,
            'email' => $email
        ]);
    }
}