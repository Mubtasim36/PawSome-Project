<?php
declare(strict_types=1);

require_once APP_PATH . '/models/PetModel.php';

/**
 * Confirmation page after submitting an adoption request.
 * URL: /adopter/requestsubmitted?pet_id=XX
 */
class RequestsubmittedController
{
    public function index(): void
    {
        $user = require_role('adopter');

        $petId = (int)($_GET['pet_id'] ?? 0);
        $name = '';

        if ($petId > 0) {
            $pm = new PetModel();
            $pet = $pm->findById($petId);
            if (is_array($pet) && isset($pet['name'])) {
                $name = (string)$pet['name'];
            }
        }

        view('adopter/request_submitted.php', [
            'user' => $user,
            'pet_id' => $petId,
            'pet_name' => $name,
            'status' => 'Pending',
        ]);
    }
}
