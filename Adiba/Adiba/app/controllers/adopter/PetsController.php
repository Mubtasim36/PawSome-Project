<?php
declare(strict_types=1);

require_once APP_PATH . '/models/PetModel.php';

class PetsController
{
    public function index(): void
    {
        require_role('adopter');
        $q = isset($_GET['q']) ? trim((string)$_GET['q']) : null;
        $pm = new PetModel();
        $pets = $pm->listAvailable($q);

        view('adopter/browse_pets.php', [
            'csrf' => csrf_token(),
            'pets' => $pets,
            'q' => $q ?? '',
        ]);
    }
}
