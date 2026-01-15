<?php
require_once dirname(__DIR__) . '/config/database.php';

class AdminUsersModel
{
    private mysqli $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAllUsers(): array
    {
        $sql = "SELECT user_id, full_name, username, email, phone, role
                FROM users
                ORDER BY user_id DESC";

        $res = $this->conn->query($sql);
        if (!$res) return [];

        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function updateRole(int $userId, string $role): bool
    {
        $allowed = ['admin', 'adopter', 'shelter'];
        if (!in_array($role, $allowed, true)) return false;

        $sql = "UPDATE users SET role=? WHERE user_id=?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("si", $role, $userId);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
    public function deleteUser(int $userId): bool
{
    if ($userId <= 0) return false;

    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $this->conn->prepare($sql);
    if (!$stmt) return false;

    $stmt->bind_param("i", $userId);
    $ok = $stmt->execute();
    $stmt->close();

    return $ok;
}
public function countUsers(): int
{
    $res = $this->conn->query("SELECT COUNT(*) AS total FROM users");
    if (!$res) return 0;
    $row = $res->fetch_assoc();
    return (int)($row['total'] ?? 0);
}

public function getUsersPage(int $offset, int $limit): array
{
    $sql = "SELECT user_id, full_name, username, email, phone, role
            FROM users
            ORDER BY user_id DESC
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
}
