<?php
declare(strict_types=1);

class EditprofileController
{
    public function index(): void
    {
        $user = require_role('adopter');
        view('adopter/edit_profile.php', [
            'user' => $user,
            'csrf' => csrf_token(),
        ]);
    }
}
