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

$adoptionModel->completeAdoption($data['adoption_id']);
$petModel->setAdopted($data['pet_id']);
$adopterModel->completeAdoptionCounters($_SESSION['user_id']);

echo json_encode(['status'=>'success','message'=>'Adoption completed']);
