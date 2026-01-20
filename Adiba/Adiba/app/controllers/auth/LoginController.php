<?php
declare(strict_types=1);

require_once APP_PATH . '/models/UserModel.php';

class LoginController
{
    public function index(): void
    {
        if (is_logged_in()) {
            redirect('adopter/dashboard');
        }

        view('auth/login.php', [
            'csrf' => csrf_token(),
        ]);
    }
}
