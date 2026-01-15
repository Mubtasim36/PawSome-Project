<?php
class AdopterModel {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getDashboardData($user_id) {
        $stmt = $this->conn->prepare("SELECT pets_adopted, adoption_requested FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProfile($user_id) {
        $stmt = $this->conn->prepare("SELECT full_name, username, email, phone FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($user_id, $data) {
        $stmt = $this->conn->prepare("UPDATE users SET full_name=?, email=?, phone=? WHERE user_id=?");
        return $stmt->execute([$data['full_name'], $data['email'], $data['phone'], $user_id]);
    }

    public function deleteProfile($user_id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE user_id = ?");
        return $stmt->execute([$user_id]);
    }

    public function incrementAdoptionRequest($user_id) {
        $stmt = $this->conn->prepare("UPDATE users SET adoption_requested = adoption_requested + 1 WHERE user_id = ?");
        $stmt->execute([$user_id]);
    }

    public function completeAdoptionCounters($user_id) {
        $stmt = $this->conn->prepare("
            UPDATE users 
            SET pets_adopted = pets_adopted + 1,
                adoption_requested = adoption_requested - 1
            WHERE user_id = ?
        ");
        $stmt->execute([$user_id]);
    }
}
