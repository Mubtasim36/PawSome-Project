<?php
session_start();
require_once '../config/database.php';
require_once '../models/AdopterModel.php';
require_once '../models/PetModel.php';
require_once '../models/AdoptionModel.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'adopter') {
    header("Location: ../login.php");
    exit;
}

$db = (new Database())->connect();
$adopterModel = new AdopterModel($db);
$petModel = new PetModel($db);
$adoptionModel = new AdoptionModel($db);

$action = $_GET['action'] ?? 'dashboard';

switch ($action) {
    case 'dashboard':
        $data = $adopterModel->getDashboardData($_SESSION['user_id']);
        include '../views/adopter/dashboard.php';
        break;

    case 'browse':
        $pets = $petModel->getAvailablePets();
        include '../views/adopter/browse_pets.php';
        break;

    case 'details':
        $pet = $petModel->getPetById($_GET['id']);
        include '../views/adopter/pet_details.php';
        break;

    case 'requests':
        include '../views/adopter/my_requests.php';
        break;

    case 'profile':
        $profile = $adopterModel->getProfile($_SESSION['user_id']);
        include '../views/adopter/profile.php';
        break;

    case 'edit_profile':
        $profile = $adopterModel->getProfile($_SESSION['user_id']);
        include '../views/adopter/edit_profile.php';
        break;

    default:
        echo "Invalid action";
}
