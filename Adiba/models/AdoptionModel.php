<?php
class AdoptionModel {
    private $conn;
    private $table = "adoptions";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createRequest($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO adoptions (pet_id, pet_name, adopter_id, shelter_id, adoption_status)
            VALUES (?, ?, ?, ?, 'Pending')
        ");
        return $stmt->execute([
            $data['pet_id'],
            $data['pet_name'],
            $data['adopter_id'],
            $data['shelter_id']
        ]);
    }

    public function getRequestsByAdopter($adopter_id) {
        $stmt = $this->conn->prepare("SELECT * FROM adoptions WHERE adopter_id = ?");
        $stmt->execute([$adopter_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function completeAdoption($adoption_id) {
        $stmt = $this->conn->prepare("UPDATE adoptions SET adoption_status = 'Completed' WHERE adoption_id = ?");
        return $stmt->execute([$adoption_id]);
    }
}
