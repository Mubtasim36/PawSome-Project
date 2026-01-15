<?php
require_once dirname(__DIR__, 3) . '/models/AdminDashboardModel.php';

class AdminStatsApiController
{
    private AdminDashboardModel $model;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->model = new AdminDashboardModel();
    }

    private function requireAdmin()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            http_response_code(401);
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
    }

    // GET /api/admin/stats
    public function index()
    {
        $this->requireAdmin();

        header("Content-Type: application/json; charset=utf-8");
        echo json_encode([
            'users' => $this->model->getTotalUsers(),
            'pets' => $this->model->getTotalPets(),
            'adoptions' => $this->model->getTotalAdoptions()
        ]);
        exit;
    }
}
