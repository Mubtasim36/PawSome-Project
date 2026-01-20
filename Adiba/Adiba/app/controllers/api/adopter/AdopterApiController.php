<?php
declare(strict_types=1);

require_once APP_PATH . '/models/UserModel.php';
require_once APP_PATH . '/models/AdoptionRequestModel.php';

class AdopterApiController
{
    private function adopter(): array
    {
        return require_role('adopter');
    }

    public function sendRequest(): void
    {
        $user = $this->adopter();
        $payload = json_decode((string)file_get_contents('php://input'), true) ?: $_POST;
        $csrf = (string)($payload['csrf'] ?? '');
        if (!csrf_verify($csrf)) {
            json_response(['success' => false, 'message' => 'Invalid security token'], 400);
        }

        $pet_id = (int)($payload['pet_id'] ?? 0);
        $note = trim((string)($payload['note'] ?? ''));
        if ($pet_id <= 0) {
            json_response(['success' => false, 'message' => 'Invalid pet'], 400);
        }

        $rm = new AdoptionRequestModel();
        $res = $rm->createRequest((int)$user['user_id'], $pet_id, $note);
        json_response(['success' => (bool)$res['ok'], 'message' => $res['message']], $res['ok'] ? 200 : 400);
    }

    public function loadRequests(): void
    {
        $user = $this->adopter();
        $rm = new AdoptionRequestModel();
        $rows = $rm->listByUser((int)$user['user_id']);
        json_response(['success' => true, 'data' => $rows]);
    }

    public function completeAdoption(): void
    {
        $user = $this->adopter();
        $payload = json_decode((string)file_get_contents('php://input'), true) ?: $_POST;
        $csrf = (string)($payload['csrf'] ?? '');
        if (!csrf_verify($csrf)) {
            json_response(['success' => false, 'message' => 'Invalid security token'], 400);
        }
        $request_id = (int)($payload['request_id'] ?? 0);
        if ($request_id <= 0) {
            json_response(['success' => false, 'message' => 'Invalid request'], 400);
        }
        $rm = new AdoptionRequestModel();
        $res = $rm->completeAdoption((int)$user['user_id'], $request_id);
        json_response(['success' => (bool)$res['ok'], 'message' => $res['message']], $res['ok'] ? 200 : 400);
    }

    public function updateProfile(): void
    {
        $user = $this->adopter();
        $payload = json_decode((string)file_get_contents('php://input'), true) ?: $_POST;
        $csrf = (string)($payload['csrf'] ?? '');
        if (!csrf_verify($csrf)) {
            json_response(['success' => false, 'message' => 'Invalid security token'], 400);
        }

        $full_name = trim((string)($payload['full_name'] ?? ''));
        $username  = trim((string)($payload['username'] ?? ''));
        $phone     = trim((string)($payload['phone'] ?? ''));

        if ($full_name === '' || $username === '' || $phone === '') {
            json_response(['success' => false, 'message' => 'All fields are required'], 400);
        }

        $um = new UserModel();
        $ok = $um->updateProfile((int)$user['user_id'], $full_name, $username, $phone);
        if (!$ok) {
            json_response(['success' => false, 'message' => 'Failed to update profile'], 500);
        }
        $_SESSION['user'] = $um->findById((int)$user['user_id']);
        json_response(['success' => true, 'message' => 'Profile updated', 'redirect' => base_url('adopter/profile')]);
    }

    public function deleteProfile(): void
    {
        $user = $this->adopter();
        $payload = json_decode((string)file_get_contents('php://input'), true) ?: $_POST;
        $csrf = (string)($payload['csrf'] ?? '');
        if (!csrf_verify($csrf)) {
            json_response(['success' => false, 'message' => 'Invalid security token'], 400);
        }

        $um = new UserModel();
        $ok = $um->deleteUser((int)$user['user_id']);
        if (!$ok) {
            json_response(['success' => false, 'message' => 'Failed to delete account'], 500);
        }

        $_SESSION = [];
        session_destroy();
        json_response(['success' => true, 'message' => 'Account deleted', 'redirect' => base_url('auth/login')]);
    }

    public function changePassword(): void
    {
        $user = $this->adopter();
        $payload = json_decode((string)file_get_contents('php://input'), true) ?: $_POST;
        $csrf = (string)($payload['csrf'] ?? '');
        if (!csrf_verify($csrf)) {
            json_response(['success' => false, 'message' => 'Invalid security token'], 400);
        }

        $current = (string)($payload['current_password'] ?? '');
        $new = (string)($payload['new_password'] ?? '');
        $confirm = (string)($payload['confirm_password'] ?? '');

        if ($current === '' || $new === '' || $confirm === '') {
            json_response(['success' => false, 'message' => 'All fields are required'], 400);
        }
        if (strlen($new) < 6) {
            json_response(['success' => false, 'message' => 'New password must be at least 6 characters'], 400);
        }
        if ($new !== $confirm) {
            json_response(['success' => false, 'message' => 'Passwords do not match'], 400);
        }

        $um = new UserModel();
        $res = $um->changePassword((int)$user['user_id'], $current, $new);
        json_response(['success' => (bool)$res['ok'], 'message' => $res['message']], $res['ok'] ? 200 : 400);
    }
}
