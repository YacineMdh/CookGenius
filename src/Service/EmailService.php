<?php
namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService {
    private PHPMailer $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);
        $this->setupMailer();
    }

    private function setupMailer(): void {
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com'; // ou votre SMTP
        $this->mailer->SMTPAuth = true;
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Username = 'yoanetilan@gmail.com'; // ou votre email
        $this->mailer->Password = 'cpua hclz lekz rpim'; // ou votre mot de passe
        $this->mailer->Port = 587;
        $this->mailer->setFrom('votre@email.com', 'Movie Bucket');
        $this->mailer->isHTML(true);
    }

    public function sendConfirmationEmail(string $email, string $token): void {
        $confirmUrl = "http://localhost:8888/confirm/{$token}";

        $this->mailer->addAddress($email);
        $this->mailer->Subject = 'Confirmez votre compte';
        $this->mailer->Body = "
            <h1>Bienvenue sur Movie Bucket!</h1>
            <p>Cliquez sur ce lien pour confirmer votre compte:</p>
            <a href='{$confirmUrl}'>{$confirmUrl}</a>
        ";

        $this->mailer->send();
    }

    public function sendResetPasswordEmail(string $email, string $token): void {
        $resetUrl = "http://localhost:8000/reset-password/{$token}";

        $this->mailer->addAddress($email);
        $this->mailer->Subject = 'Réinitialisation de mot de passe';
        $this->mailer->Body = "
            <h1>Réinitialisation de mot de passe</h1>
            <p>Cliquez sur ce lien pour réinitialiser votre mot de passe:</p>
            <a href='{$resetUrl}'>{$resetUrl}</a>
        ";

        $this->mailer->send();
    }
}