<?php
require_once dirname(__DIR__, 2) . '/models/AdminPetsModel.php';

class M_PetsController
{
    private AdminPetsModel $model;

    public function __construct()
    {
        $this->model = new AdminPetsModel();
    }

    private function requireAdmin()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            header("Location: /Expeditioners_Project/public/login");
            exit;
        }
    }

    //GET /admin/pets
    public function index()
    {
        $this->requireAdmin();
        require dirname(__DIR__, 2) . '/views/admin/M_Pets.php';
    }

    //POST /admin/pets/delete
    public function delete()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /Expeditioners_Project/public/admin/pets");
            exit;
        }

        $petId = isset($_POST['pet_id']) ? (int)$_POST['pet_id'] : 0;

        if ($petId > 0) {
            $this->model->deletePet($petId);

            //OPTIONAL: log activity (only if you already use ActivityLogModel)
            if (file_exists(dirname(__DIR__, 2) . '/models/ActivityLogModel.php')) {
                require_once dirname(__DIR__, 2) . '/models/ActivityLogModel.php';
                $log = new ActivityLogModel();
                $log->log(
                    'system',
                    "Pet ID {$petId} removed",
                    $_SESSION['user']['user_id'] ?? null
                );
            }
        }

        header("Location: /Expeditioners_Project/public/admin/pets");
        exit;
    }
}
