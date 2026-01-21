<?php
require_once dirname(__DIR__, 3) . '/models/AdminAdoptionsModel.php';

class AdoptionsApiController
{
    private AdminAdoptionsModel $model;

    public function __construct()
    {
        $this->model = new AdminAdoptionsModel();
    }

    private function requireAdmin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
    }

    public function index()
    {
        $this->requireAdmin();

        header("Content-Type: application/json; charset=utf-8");

        $page  = max(1, (int)($_GET['page'] ?? 1));
        $limit = max(1, (int)($_GET['limit'] ?? 10));
        $offset = ($page - 1) * $limit;

        $data = $this->model->getAdoptionsPage($offset, $limit);
        $total = $this->model->countAdoptions();

        echo json_encode([
            'total' => $total,
            'page'  => $page,
            'limit' => $limit,
            'adoptions' => $data
        ]);
        exit;
    }
}
