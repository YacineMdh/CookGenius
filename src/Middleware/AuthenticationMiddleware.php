<?php

namespace App\Middleware;

class AuthenticationMiddleware
{
    private const PUBLIC_ROUTES = [
        '/login',
        '/register',
        '/forgot-password',
        '/confirm',
        '/about',
    ];

    public function __construct()
    {
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function handle(): bool
    {
        $path = $_SERVER['PATH_INFO'] ?? '/';
        //error_log("path: " . print_r($path, true));
        // Allow access to public routes
        if (in_array($path, self::PUBLIC_ROUTES) || str_starts_with($path, '/confirm/')) {
            return true;
        }

        // Check if user is authenticated
        if (!isset($_SESSION['user_id'])) {
            //
            error_log("user_id: " . print_r($_SESSION['user_id'], true));
            header('Location: /login');
            exit;
        }

        return true;
    }
}