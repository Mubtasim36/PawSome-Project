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
        }

        header("Location: /Expeditioners_Project/public/admin/users");
        exit;
    }
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

        // OPTIONAL: log activity
        require_once dirname(__DIR__, 2) . '/models/ActivityLogModel.php';
        $log = new ActivityLogModel();
        $log->log(
            'user',
            "User ID {$userId} deleted",
            $_SESSION['user']['user_id'] ?? null
        );
    }

    header("Location: /Expeditioners_Project/public/admin/users");
    exit;
}
}
