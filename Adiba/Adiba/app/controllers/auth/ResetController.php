<?php
declare(strict_types=1);

class ResetController
{
    public function index(): void
    {
        if (is_logged_in()) {
            redirect('adopter/dashboard');
        }

        $email = (string)($_GET['email'] ?? '');
        $token = (string)($_GET['token'] ?? '');

        view('auth/reset.php', [
            'csrf' => csrf_token(),
            'email' => $email,
            'token' => $token,
        ]);
    }
}
