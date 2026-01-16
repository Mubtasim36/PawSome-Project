<?php
require_once dirname(__DIR__, 2) . '/models/AdminDashboardModel.php';

class AdminDashboardController
{
    private AdminDashboardModel $model;

    public function __construct()
    {
        $this->model = new AdminDashboardModel();
    }

    private function requireAdmin()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            header("Location: /Expeditioners_Project/public/login");
            exit;
        }
    }

    public function index()
    {
        $this->requireAdmin();

        $totalUsers = $this->model->getTotalUsers();
        $totalPets = $this->model->getTotalPets();
        $totalAdoptions = $this->model->getTotalAdoptions();
        $logs = $this->model->getRecentActivity(10);

        require dirname(__DIR__, 2) . '/views/admin/AdminDashboard.php';
    }
}
