<?php
require_once dirname(__DIR__) . '/models/PetModel.php';

class BrowsePetsController
{
    public function index()
    {
        $petModel = new PetModel();
        $pets = $petModel->getAllForBrowse();  


        require dirname(__DIR__) . '/views/public/browsepets.php';
    }
}