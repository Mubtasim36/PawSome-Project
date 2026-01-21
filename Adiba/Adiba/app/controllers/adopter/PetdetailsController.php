<?php
declare(strict_types=1);

require_once APP_PATH . '/models/PetModel.php';

class PetdetailsController
{
    public function index(): void
    {
        require_role('adopter');

        $pet_id = (int)($_GET['pet_id'] ?? 0);
        if ($pet_id <= 0) {
            redirect('adopter/pets');
        }

        $pm = new PetModel();
        $pet = $pm->findById($pet_id);
        if (!$pet) {
            http_response_code(404);
            echo '<h1>Pet not found</h1>';
            exit;
        }

        view('adopter/pet_details.php', [
            'csrf' => csrf_token(),
            'pet' => $pet,
        ]);
    }
}
