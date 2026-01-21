<?php
declare(strict_types=1);

class RequestsController
{
    public function index(): void
    {
        $user = require_role('adopter');

        require_once APP_PATH . '/models/UserModel.php';
        $um = new UserModel();
        $fresh = $um->findById((int)$user['user_id']);
        if ($fresh) {
            $_SESSION['user'] = $fresh;
            $user = $fresh;
        }
        view('adopter/my_requests.php', [
            'user' => $user,
            'csrf' => csrf_token(),
        ]);
    }
}
