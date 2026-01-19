<?php
require_once dirname(__DIR__, 2) . '/models/AdminUsersModel.php';

class M_UsersController
{
    private AdminUsersModel $model;

    public function __construct()
    {
        $this->model = new AdminUsersModel();
    }

    private function requireAdmin()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            header("Location: /Expeditioners_Project/public/login");
            exit;
        }
    }

    // GET /admin/users
    public function index()
    {
        $this->requireAdmin();
        require dirname(__DIR__, 2) . '/views/admin/M_Users.php';
    }

    // POST /admin/users/role
    public function updateRole()
    {
        $this->requireAdmin();

        $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
        $role   = isset($_POST['role']) ? trim($_POST['role']) : '';

        if ($userId > 0 && $role !== '') {
            $this->model->updateRole($userId, $role);

            require_once dirname(__DIR__, 2) . '/models/ActivityLogModel.php';
            $log = new ActivityLogModel();
            $log->log('user', "User ID {$userId} role updated to {$role}", $_SESSION['user']['user_id'] ?? null);
        }

        header("Location: /Expeditioners_Project/public/admin/users");
        exit;
    }

    // POST /admin/users/delete
    public function delete()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /Expeditioners_Project/public/admin/users");
            exit;
        }

        $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

        if ($userId > 0) {
            $this->model->deleteUser($userId);

            require_once dirname(__DIR__, 2) . '/models/ActivityLogModel.php';
            $log = new ActivityLogModel();
            $log->log('user', "User ID {$userId} deleted", $_SESSION['user']['user_id'] ?? null);
        }

        header("Location: /Expeditioners_Project/public/admin/users");
        exit;
    }

    // GET /admin/users/view?id=123
    public function view()
    {
        $this->requireAdmin();

        $userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($userId <= 0) {
            $viewError = "Invalid user id.";
            require dirname(__DIR__, 2) . '/views/admin/UserProfile.php';
            return;
        }

        $u = $this->model->getUserById($userId);
        if (!$u) {
            $viewError = "User not found.";
            require dirname(__DIR__, 2) . '/views/admin/UserProfile.php';
            return;
        }

        $username = $u['username'] ?? '';
        $fullName = $u['full_name'] ?? '';
        $email    = $u['email'] ?? '';
        $phone    = $u['phone'] ?? '';
        $role     = $u['role'] ?? '';

        $joinedOn = '';
        if (!empty($u['created_at'])) {
            $joinedOn = date('Y-m-d', strtotime($u['created_at']));
        }

        $userProfilePicture = $this->getUserPictureName($userId, $role);

        require dirname(__DIR__, 2) . '/views/admin/UserProfile.php';
    }

    // POST /admin/users/make-admin
    public function makeAdmin()
    {
        $this->requireAdmin();

        $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
        if ($userId <= 0) {
            header("Location: /Expeditioners_Project/public/admin/users?err=Invalid%20user");
            exit;
        }

        $u = $this->model->getUserById($userId);
        if (!$u) {
            header("Location: /Expeditioners_Project/public/admin/users?err=User%20not%20found");
            exit;
        }

        if (($u['role'] ?? '') === 'admin') {
            header("Location: /Expeditioners_Project/public/admin/users/view?id={$userId}&ok=Already%20an%20admin");
            exit;
        }

        $ok = $this->model->makeAdmin($userId);

        if ($ok) {
            require_once dirname(__DIR__, 2) . '/models/ActivityLogModel.php';
            $log = new ActivityLogModel();
            $log->log('user', "User ID {$userId} promoted to admin", $_SESSION['user']['user_id'] ?? null);

            header("Location: /Expeditioners_Project/public/admin/users/view?id={$userId}&ok=User%20promoted%20to%20admin");
            exit;
        }

        header("Location: /Expeditioners_Project/public/admin/users/view?id={$userId}&err=Could%20not%20promote%20user");
        exit;
    }

    private function getUserPictureName(int $userId, string $role): string
    {
        $dir = __DIR__ . '/../../../public/Assets/images/users/';

        // user uploaded picture
        if (file_exists($dir . "user_$userId.jpg")) return "user_$userId.jpg";
        if (file_exists($dir . "user_$userId.png")) return "user_$userId.png";

        // fallback by role
        if ($role === 'shelter') return "shelter.jpg";
        if ($role === 'adopter') return "adopter.jpg";
        if ($role === 'admin') {
            // check admin pictures
            $adminDir = __DIR__ . '/../../../public/Assets/images/admins/';
            if (file_exists($adminDir . "admin_$userId.jpg")) return "admin_$userId.jpg";
            if (file_exists($adminDir . "admin_$userId.png")) return "admin_$userId.png";
            return "admin_default.jpg";
        }
    }
}
