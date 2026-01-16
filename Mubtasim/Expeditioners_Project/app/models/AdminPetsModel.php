<?php
require_once dirname(__DIR__) . '/config/database.php';

class AdminPetsModel
{
    private mysqli $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function countPets(): int
    {
        $res = $this->conn->query("SELECT COUNT(*) AS total FROM pets");
        if (!$res) return 0;
        $row = $res->fetch_assoc();
        return (int)($row['total'] ?? 0);
    }

    public function getPetsPage(int $offset, int $limit): array
    {
        $sql = "SELECT pet_id, shelter_id, name, species, breed, age_years, health_status, adoption_status
                FROM pets
                ORDER BY pet_id DESC
                LIMIT ? OFFSET ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return [];

        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();

        $res = $stmt->get_result();
        $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];

        $stmt->close();
        return $rows;
    }

    public function deletePet(int $petId): bool
    {
        if ($petId <= 0) return false;

        $stmt = $this->conn->prepare("DELETE FROM pets WHERE pet_id=?");
        if (!$stmt) return false;

        $stmt->bind_param("i", $petId);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }
}
