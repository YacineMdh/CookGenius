<?php

namespace App\Controller;



use App\Service\AuthenticationService;
use App\Core\Service\ViewManager;
use App\Service\EmailService;

class AuthController {
    private AuthenticationService $authService;
    private ViewManager $viewManager;

    public function __construct() {
        $this->authService = new AuthenticationService();
        $this->viewManager = new ViewManager();
    }

    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->authService->login(
                $_POST['email'],
                $_POST['password']
            );

            if ($user) {
                header('Location: /dashboard');
                exit;
            }
        }

        $this->viewManager->render('auth/login');
    }

    public function register(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->authService->register(
                $_POST['email'],
                $_POST['password']
            );

            header('Location: /login');
            exit;
        }

        $this->viewManager->render('auth/register');
    }

    public function confirm(string $token): void {
        if ($this->authService->confirmAccount($token)) {
            header('Location: /login');
            exit;
        }
        header('Location: /error');
    }
    public function forgotPassword(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $this->authService->requestPasswordReset($_POST['email']);
            $emailService = new EmailService();
            $emailService->sendResetPasswordEmail($_POST['email'], $token);

            header('Location: /login');
            exit;
        }

        $this->viewManager->render('auth/forgot');
    }
}
