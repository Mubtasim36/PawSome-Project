<?php
require_once dirname(__DIR__, 2) . '/models/AdminAdoptionsModel.php';

class M_AdoptionsController
{
    private AdminAdoptionsModel $model;

    public function __construct()
    {
        $this->model = new AdminAdoptionsModel();
    }

    private function requireAdmin()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            header("Location: /Expeditioners_Project/public/login");
            exit;
        }
    }

    //GET /admin/adoptions
    public function index()
    {
        $this->requireAdmin();
        require dirname(__DIR__, 2) . '/views/admin/M_Adoptions.php';
    }

    //POST /admin/adoptions/status
    public function updateStatus()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /Expeditioners_Project/public/admin/adoptions");
            exit;
        }

        $adoptionId = (int)($_POST['adoption_id'] ?? 0);
        $status = trim($_POST['status'] ?? '');

        if ($adoptionId > 0 && $status !== '') {
            $this->model->updateStatus($adoptionId, $status);
        }

        header("Location: /Expeditioners_Project/public/admin/adoptions");
        exit;
    }

    //POST /admin/adoptions/delete
    public function delete()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /Expeditioners_Project/public/admin/adoptions");
            exit;
        }

        $adoptionId = (int)($_POST['adoption_id'] ?? 0);
        if ($adoptionId > 0) {
            $this->model->deleteAdoption($adoptionId);
        }

        header("Location: /Expeditioners_Project/public/admin/adoptions");
        exit;
    }
}
