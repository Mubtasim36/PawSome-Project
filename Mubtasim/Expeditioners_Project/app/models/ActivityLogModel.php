<?php
require_once dirname(__DIR__) . '/config/database.php';

class ActivityLogModel
{
    private mysqli $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function log(string $category, string $description, ?int $performedBy)
    {
        $sql = "INSERT INTO activity_log (category, description, performed_by)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return;

        $stmt->bind_param("ssi", $category, $description, $performedBy);
        $stmt->execute();
        $stmt->close();
    }
}
