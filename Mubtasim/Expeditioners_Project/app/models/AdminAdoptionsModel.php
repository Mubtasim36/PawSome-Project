<?php
require_once dirname(__DIR__) . '/config/database.php';

class AdminAdoptionsModel
{
    private mysqli $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function countAdoptions(): int
    {
        $res = $this->conn->query("SELECT COUNT(*) AS total FROM adoptions");
        if (!$res) return 0;

        $row = $res->fetch_assoc();
        return (int)($row['total'] ?? 0);
    }

    public function getAdoptionsPage(int $offset, int $limit): array
    {
        $sql = "
            SELECT
                adoption_id,
                pet_name,
                adopter_id,
                shelter_id,
                adoption_status,
                requested_at
            FROM adoptions
            ORDER BY adoption_id DESC
            LIMIT ? OFFSET ?
        ";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return [];

        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();

        $res = $stmt->get_result();
        $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];

        $stmt->close();
        return $rows;
    }

    public function updateStatus(int $adoptionId, string $status): bool
    {
        $allowed = ['Pending', 'Approved', 'Rejected', 'Completed'];
        if (!in_array($status, $allowed, true)) return false;

        $stmt = $this->conn->prepare(
            "UPDATE adoptions SET adoption_status=? WHERE adoption_id=?"
        );
        if (!$stmt) return false;

        $stmt->bind_param("si", $status, $adoptionId);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }
}
