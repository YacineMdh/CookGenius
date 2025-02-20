<?php

namespace App\Controller;



use App\Service\AuthenticationService;
use App\Core\Service\ViewManager;
use App\Service\EmailService;

class AuthController {
    private AuthenticationService $authService;
    private ViewManager $viewManager;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->authService = new AuthenticationService();
        $this->viewManager = new ViewManager();
    }

    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->authService->login(
                $_POST['email'],
                $_POST['password']
            );
            //error_log("Debug: " . print_r($user, true));
            if ($user) {
                $_SESSION['user_id'] = $user->getId();
                error_log("id: " . print_r($user->getId(), true));
                header('Location: /');
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
            //log the token

            $emailService = new EmailService();
            $emailService->sendResetPasswordEmail($_POST['email'], $token);

            header('Location: /login');
            exit;
        }

        $this->viewManager->render('auth/forgot');
    }

    public function logout(): void {
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function resetPassword(string $token): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->authService->resetPassword($token, $_POST['password']);
            error_log("Debug: " . print_r( $_POST['password'] , true));
            header('Location: /login');
            exit;
        }

        $this->viewManager->render('auth/reset', ['token' => $token]);
    }


}
