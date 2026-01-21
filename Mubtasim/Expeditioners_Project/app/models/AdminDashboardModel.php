<?php
require_once dirname(__DIR__) . '/config/database.php';

class AdminDashboardModel
{
    private mysqli $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    /* COUNTS */

    public function getTotalUsers(): int
    {
        return $this->scalar("SELECT COUNT(*) FROM users");
    }

    public function getTotalPets(): int
    {
        return $this->scalar("SELECT COUNT(*) FROM pets");
    }

    public function getTotalAdoptions(): int
    {
        return $this->scalar("SELECT COUNT(*) FROM adoptions");
    }

    /* ACTIVITY LOG */

    public function getRecentActivity(int $limit = 10): array
    {
        $sql = "
            SELECT 
                a.log_id,
                a.category,
                a.description,
                u.username AS performed_by,
                a.created_at
            FROM activity_log a
            LEFT JOIN users u ON a.performed_by = u.user_id
            ORDER BY a.created_at DESC
            LIMIT ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    private function scalar(string $sql): int
    {
        $res = $this->conn->query($sql);
        if (!$res) return 0;

        $row = $res->fetch_row();
        return (int)$row[0];
    }
}
