<?php
require_once dirname(__DIR__, 3) . '/models/AdminUsersModel.php';

class UsersApiController
{
    private AdminUsersModel $model;

    public function __construct()
    {
        $this->model = new AdminUsersModel();
    }

    private function requireAdmin(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            http_response_code(401);
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
    }

    // GET /api/admin/users?page=1&limit=10
    public function index(): void
    {
        $this->requireAdmin();

        header("Content-Type: application/json; charset=utf-8");

        $page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

        if ($page < 1) $page = 1;
        if ($limit < 1) $limit = 10;
        if ($limit > 50) $limit = 50;

        $total  = $this->model->countUsers();
        $offset = ($page - 1) * $limit;

        $users = $this->model->getUsersPage($offset, $limit);

        echo json_encode([
            'total' => $total,
            'page'  => $page,
            'limit' => $limit,
            'users' => $users
        ]);
        exit;
    }
}
