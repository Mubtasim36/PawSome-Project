<?php
declare(strict_types=1);

class ForgotController
{
    public function index(): void
    {
        if (is_logged_in()) {
            redirect('adopter/dashboard');
        }

        view('auth/forgot.php', [
            'csrf' => csrf_token(),
        ]);
    }
}
