<?php
declare(strict_types=1);

class ChangepasswordController
{
    public function index(): void
    {
        require_role('adopter');
        view('adopter/change_password.php', [
            'csrf' => csrf_token(),
        ]);
    }
}
