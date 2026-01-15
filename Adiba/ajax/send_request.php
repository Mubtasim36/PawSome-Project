<?php
session_start();
require_once '../config/database.php';
require_once '../models/AdoptionModel.php';
require_once '../models/PetModel.php';
require_once '../models/AdopterModel.php';

$data = json_decode(file_get_contents("php://input"), true);

$db = (new Database())->connect();
$adoptionModel = new AdoptionModel($db);
$petModel = new PetModel($db);
$adopterModel = new AdopterModel($db);

$pet = $petModel->getPetById($data['pet_id']);

$requestData = [
    'pet_id' => $pet['pet_id'],
    'pet_name' => $pet['name'],
    'adopter_id' => $_SESSION['user_id'],
    'shelter_id' => $pet['shelter_id']
];

$adoptionModel->createRequest($requestData);
$petModel->setPending($pet['pet_id']);
$adopterModel->incrementAdoptionRequest($_SESSION['user_id']);

echo json_encode(['status'=>'success','message'=>'Adoption request sent']);
