<?php

require_once dirname(__DIR__) . '/models/PetModel.php';

class PetDetailsController
{
    public function index()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            http_response_code(400);
            echo "Invalid pet id.";
            return;
        }

        $petModel = new PetModel();
        $pet = $petModel->getById($id);

        if (!$pet) {
            http_response_code(404);
            echo "Pet not found.";
            return;
        }

        require dirname(__DIR__) . '/views/public/petdetails.php';
    }
}
