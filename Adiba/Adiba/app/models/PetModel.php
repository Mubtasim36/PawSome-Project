<?php
declare(strict_types=1);

class PetModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = db();
    }

    public function listAvailable(?string $q = null): array
    {
        if ($q) {
            $like = '%' . $q . '%';
            $stmt = $this->db->prepare(
                'SELECT pet_id, name, species, breed, age_years, gender, location, rescued_by, personality, health_status, adoption_fee, adoption_status
                 FROM pets
                 WHERE adoption_status = "Available"
                   AND (name LIKE ? OR species LIKE ? OR breed LIKE ? OR location LIKE ?)
                 ORDER BY pet_id DESC'
            );
            $stmt->execute([$like, $like, $like, $like]);
            return $stmt->fetchAll();
        }

        $stmt = $this->db->query(
            'SELECT pet_id, name, species, breed, age_years, gender, location, rescued_by, personality, health_status, adoption_fee, adoption_status
             FROM pets
             WHERE adoption_status = "Available"
             ORDER BY pet_id DESC'
        );
        return $stmt->fetchAll();
    }

    public function findById(int $pet_id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM pets WHERE pet_id=? LIMIT 1');
        $stmt->execute([$pet_id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
