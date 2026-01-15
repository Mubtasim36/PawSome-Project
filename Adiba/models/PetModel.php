<?php
class PetModel {
    private $conn;
    private $table = "pets";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAvailablePets() {
        $stmt = $this->conn->prepare("SELECT * FROM pets WHERE adoption_status = 'Available'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPetById($pet_id) {
        $stmt = $this->conn->prepare("SELECT * FROM pets WHERE pet_id = ?");
        $stmt->execute([$pet_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function setPending($pet_id) {
        $stmt = $this->conn->prepare("UPDATE pets SET adoption_status = 'Pending' WHERE pet_id = ?");
        $stmt->execute([$pet_id]);
    }

    public function setAdopted($pet_id) {
        $stmt = $this->conn->prepare("UPDATE pets SET adoption_status = 'Adopted' WHERE pet_id = ?");
        $stmt->execute([$pet_id]);
    }
}
