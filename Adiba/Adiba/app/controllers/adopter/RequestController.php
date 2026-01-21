<?php
declare(strict_types=1);

require_once APP_PATH . '/models/PetModel.php';
require_once APP_PATH . '/models/AdoptionRequestModel.php';

/**
 * Adoption request page (form-based flow).
 *
 * Required UX:
 * Pet Details -> Request Page (collects Full Name, Address, Phone) ->
 * Request Submitted (shows message + Pending)
 */
class RequestController
{
    public function index(): void
    {
        $user = require_role('adopter');

        $petId = (int)($_GET['pet_id'] ?? 0);
        if ($petId <= 0) {
            redirect('adopter/pets');
        }

        $pm = new PetModel();
        $pet = $pm->findById($petId);
        if (!$pet) {
            http_response_code(404);
            echo '<h1>Pet not found</h1>';
            exit;
        }

        // POST: submit the request
        if (strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $csrf = (string)($_POST['csrf'] ?? '');
            if (!csrf_verify($csrf)) {
                $_SESSION['error'] = 'Invalid security token. Please try again.';
                redirect('adopter/request?pet_id=' . $petId);
            }

            $fullName = trim((string)($_POST['full_name'] ?? ''));
            $address  = trim((string)($_POST['address'] ?? ''));
            $phone    = trim((string)($_POST['phone'] ?? ''));

            if ($fullName === '' || $address === '' || $phone === '') {
                $_SESSION['error'] = 'Full name, address, and phone are required.';
                redirect('adopter/request?pet_id=' . $petId);
            }

            $rm = new AdoptionRequestModel();
            $res = $rm->createDetailedRequest(
                (int)($user['user_id'] ?? 0),
                (string)($user['username'] ?? ''),
                $petId,
                $fullName,
                $address,
                $phone
            );

            if (!$res['ok']) {
                $_SESSION['error'] = $res['message'] ?? 'Failed to send request.';
                redirect('adopter/request?pet_id=' . $petId);
            }

            // ✅ Success page
            redirect('adopter/requestsubmitted?pet_id=' . $petId);
        }

        // GET: show form
        view('adopter/request.php', [
            'user' => $user,
            'pet' => $pet,
            'csrf' => csrf_token(),
        ]);
    }
}
