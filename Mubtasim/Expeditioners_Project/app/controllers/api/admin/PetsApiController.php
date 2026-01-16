<?php
require_once dirname(__DIR__, 3) . '/models/AdminPetsModel.php';

class PetsApiController
{
    private AdminPetsModel $model;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->model = new AdminPetsModel();
    }

    private function requireAdminApi(): void
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            http_response_code(401);
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
    }

    // GET /api/admin/pets?page=1&limit=10
    public function index(): void
    {
        $this->requireAdminApi();

        $page  = (int)($_GET['page'] ?? 1);
        $limit = (int)($_GET['limit'] ?? 10);

        if ($page < 1) $page = 1;
        if ($limit < 1 || $limit > 50) $limit = 10;

        $total  = $this->model->countPets();
        $offset = ($page - 1) * $limit;

        $pets = $this->model->getPetsPage($offset, $limit);

        header("Content-Type: application/json; charset=utf-8");
        echo json_encode([
            'total' => $total,
            'page'  => $page,
            'limit' => $limit,
            'pets'  => $pets
        ]);
        exit;
    }
}
