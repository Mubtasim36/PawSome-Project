<?php
session_start();
require_once '../config/database.php';
require_once '../models/AdoptionModel.php';

$db = (new Database())->connect();
$model = new AdoptionModel($db);

$requests = $model->getRequestsByAdopter($_SESSION['user_id']);
echo json_encode($requests);
