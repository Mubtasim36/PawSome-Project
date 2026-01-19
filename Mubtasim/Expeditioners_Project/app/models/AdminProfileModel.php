<?php
// app/models/AdminProfileModel.php

require_once dirname(__DIR__) . '/config/database.php';

class AdminProfileModel
{
    private mysqli $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAdminById(int $userId): ?array
    {
        $sql = "SELECT user_id, full_name, username, email, phone, role
                FROM users
                WHERE user_id = ? AND role = 'admin'
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return null;

        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $res = $stmt->get_result();
        $row = $res ? $res->fetch_assoc() : null;

        $stmt->close();
        return $row ?: null;
    }

    // ✅ count total admins
    public function countAdmins(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM users WHERE role='admin'";
        $res = $this->conn->query($sql);
        if (!$res) return 0;

        $row = $res->fetch_assoc();
        return (int)($row['total'] ?? 0);
    }

    // ✅ delete admin by id (only if that user is admin)
    public function deleteAdminById(int $userId): bool
    {
        $sql = "DELETE FROM users WHERE user_id = ? AND role='admin' LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("i", $userId);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }
}
