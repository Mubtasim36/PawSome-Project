<?php
declare(strict_types=1);

class UserModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = db();
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findById(int $user_id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE user_id = ? LIMIT 1');
        $stmt->execute([$user_id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function createAdopter(string $full_name, string $username, string $email, string $phone, string $password): int
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        // NOTE: Keep inserts compatible with schemas that don't include `adoption_requested`.
        $stmt = $this->db->prepare('INSERT INTO users (full_name, username, email, phone, password, role, pets_adopted)
                                    VALUES (?, ?, ?, ?, ?, "adopter", 0)');
        $stmt->execute([$full_name, $username, $email, $phone, $hash]);
        return (int)$this->db->lastInsertId();
    }

    public function verifyLogin(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        if (!$user) return null;
        if (!password_verify($password, (string)$user['password'])) return null;
        return $user;
    }

    public function updateProfile(int $user_id, string $full_name, string $username, string $phone): bool
    {
        $stmt = $this->db->prepare('UPDATE users SET full_name=?, username=?, phone=? WHERE user_id=?');
        return $stmt->execute([$full_name, $username, $phone, $user_id]);
    }

    public function updateProfilePicture(int $user_id, string $filename): bool
    {
        // This requires a `profile_picture` column in `users`.
        $stmt = $this->db->prepare('UPDATE users SET profile_picture=? WHERE user_id=?');
        return $stmt->execute([$filename, $user_id]);
    }

    public function deleteUser(int $user_id): bool
    {
        // Cascade will handle adoption_requests if FK is defined with ON DELETE CASCADE.
        $stmt = $this->db->prepare('DELETE FROM users WHERE user_id=?');
        return $stmt->execute([$user_id]);
    }

    public function changePassword(int $user_id, string $current_password, string $new_password): array
    {
        $user = $this->findById($user_id);
        if (!$user) return ['ok' => false, 'message' => 'User not found'];
        if (!password_verify($current_password, (string)$user['password'])) {
            return ['ok' => false, 'message' => 'Current password is incorrect'];
        }
        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare('UPDATE users SET password=? WHERE user_id=?');
        $stmt->execute([$hash, $user_id]);
        return ['ok' => true, 'message' => 'Password changed successfully'];
    }

    public function createPasswordReset(string $email): ?string
    {
        $user = $this->findByEmail($email);
        if (!$user) return null;

        $token = bin2hex(random_bytes(16));
        $expiresAt = (new DateTime('+30 minutes'))->format('Y-m-d H:i:s');

        // Invalidate older tokens for this email
        $this->db->prepare('DELETE FROM password_resets WHERE email=?')->execute([$email]);

        $stmt = $this->db->prepare('INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)');
        $stmt->execute([$email, $token, $expiresAt]);

        return $token;
    }

    public function resetPassword(string $email, string $token, string $new_password): array
    {
        $stmt = $this->db->prepare('SELECT * FROM password_resets WHERE email=? AND token=? LIMIT 1');
        $stmt->execute([$email, $token]);
        $row = $stmt->fetch();
        if (!$row) return ['ok' => false, 'message' => 'Invalid reset link'];

        $expires = new DateTime((string)$row['expires_at']);
        if ($expires < new DateTime('now')) {
            return ['ok' => false, 'message' => 'Reset link expired'];
        }

        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $this->db->prepare('UPDATE users SET password=? WHERE email=?')->execute([$hash, $email]);
        $this->db->prepare('DELETE FROM password_resets WHERE email=?')->execute([$email]);

        return ['ok' => true, 'message' => 'Password reset successfully'];
    }
}
