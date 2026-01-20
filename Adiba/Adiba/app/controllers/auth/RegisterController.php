<?php
declare(strict_types=1);

class RegisterController
{
    public function index(): void
    {
        if (is_logged_in()) {
            redirect('adopter/dashboard');
        }

        view('auth/register.php', [
            'csrf' => csrf_token(),
        ]);
    }
}
