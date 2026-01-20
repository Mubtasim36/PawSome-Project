<?php
declare(strict_types=1);

require_once APP_PATH . '/models/UserModel.php';

class AuthApiController
{
    public function login(): void
    {
        $payload = json_decode((string)file_get_contents('php://input'), true) ?: $_POST;
        $email = trim((string)($payload['email'] ?? ''));
        $password = (string)($payload['password'] ?? '');
        $csrf = (string)($payload['csrf'] ?? '');

        if (!csrf_verify($csrf)) {
            json_response(['success' => false, 'message' => 'Invalid security token'], 400);
        }
        if ($email === '' || $password === '') {
            json_response(['success' => false, 'message' => 'Email and password are required'], 400);
        }

        $um = new UserModel();
        $user = $um->verifyLogin($email, $password);
        if (!$user) {
            json_response(['success' => false, 'message' => 'Invalid credentials'], 401);
        }

        // Only adopter flow included here (project requirement)
        if (($user['role'] ?? '') !== 'adopter') {
            json_response(['success' => false, 'message' => 'Only adopters can login here'], 403);
        }

        $_SESSION['user'] = $user;
        json_response(['success' => true, 'redirect' => base_url('adopter/dashboard')]);
    }

    public function register(): void
    {
        $payload = json_decode((string)file_get_contents('php://input'), true) ?: $_POST;
        $csrf = (string)($payload['csrf'] ?? '');
        if (!csrf_verify($csrf)) {
            json_response(['success' => false, 'message' => 'Invalid security token'], 400);
        }

        $full_name = trim((string)($payload['full_name'] ?? ''));
        $username = trim((string)($payload['username'] ?? ''));
        $email = trim((string)($payload['email'] ?? ''));
        $phone = trim((string)($payload['phone'] ?? ''));
        $password = (string)($payload['password'] ?? '');

        if ($full_name === '' || $username === '' || $email === '' || $phone === '' || $password === '') {
            json_response(['success' => false, 'message' => 'All fields are required'], 400);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            json_response(['success' => false, 'message' => 'Invalid email address'], 400);
        }
        if (strlen($password) < 6) {
            json_response(['success' => false, 'message' => 'Password must be at least 6 characters'], 400);
        }

        $um = new UserModel();
        if ($um->findByEmail($email)) {
            json_response(['success' => false, 'message' => 'Email already exists'], 409);
        }

        $user_id = $um->createAdopter($full_name, $username, $email, $phone, $password);
        $user = $um->findById($user_id);
        $_SESSION['user'] = $user;

        json_response(['success' => true, 'redirect' => base_url('adopter/dashboard')]);
    }

    public function requestReset(): void
    {
        $payload = json_decode((string)file_get_contents('php://input'), true) ?: $_POST;
        $csrf = (string)($payload['csrf'] ?? '');
        if (!csrf_verify($csrf)) {
            json_response(['success' => false, 'message' => 'Invalid security token'], 400);
        }
        $email = trim((string)($payload['email'] ?? ''));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            json_response(['success' => false, 'message' => 'Enter a valid email'], 400);
        }

        $um = new UserModel();
        $token = $um->createPasswordReset($email);

        // Academic / local project: show the reset link on-screen (no email integration)
        if (!$token) {
            json_response(['success' => true, 'message' => 'If that email exists, a reset link was generated.']);
        }

        $link = base_url('auth/reset') . '?email=' . urlencode($email) . '&token=' . urlencode($token);
        json_response(['success' => true, 'message' => 'Reset link generated (demo).', 'reset_link' => $link]);
    }

    public function resetPassword(): void
    {
        $payload = json_decode((string)file_get_contents('php://input'), true) ?: $_POST;
        $csrf = (string)($payload['csrf'] ?? '');
        if (!csrf_verify($csrf)) {
            json_response(['success' => false, 'message' => 'Invalid security token'], 400);
        }
        $email = trim((string)($payload['email'] ?? ''));
        $token = trim((string)($payload['token'] ?? ''));
        $password = (string)($payload['password'] ?? '');

        if ($email === '' || $token === '' || $password === '') {
            json_response(['success' => false, 'message' => 'All fields are required'], 400);
        }
        if (strlen($password) < 6) {
            json_response(['success' => false, 'message' => 'Password must be at least 6 characters'], 400);
        }

        $um = new UserModel();
        $res = $um->resetPassword($email, $token, $password);
        if (!$res['ok']) {
            json_response(['success' => false, 'message' => $res['message']], 400);
        }

        json_response(['success' => true, 'message' => $res['message'], 'redirect' => base_url('auth/login')]);
    }
}
