<?php
declare(strict_types=1);

class AdoptionRequestModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = db();
    }

    private function hasRequestDetails(): bool
    {
        try {
            $stmt = $this->db->prepare("SHOW TABLES LIKE 'adoption_request_details'");
            $stmt->execute();
            return (bool)$stmt->fetch();
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * ✅ New form-based request flow (REQUIRED)
     * Inserts into:
     *  - adoptions (workflow/status)
     *  - adoption_request_details (full_name/address/phone + adopter info)
     */
    public function createDetailedRequest(
        int $adopter_id,
        string $username,
        int $pet_id,
        string $full_name,
        string $address,
        string $phone
    ): array {
        // Basic validation
        $username  = trim($username);
        $full_name = trim($full_name);
        $address   = trim($address);
        $phone     = trim($phone);

        if ($adopter_id <= 0 || $pet_id <= 0 || $username === '' || $full_name === '' || $address === '' || $phone === '') {
            return ['ok' => false, 'message' => 'All fields are required'];
        }

        // Fetch pet info needed for adoptions insert
        $p = $this->db->prepare("SELECT pet_id, name, shelter_id FROM pets WHERE pet_id=? LIMIT 1");
        $p->execute([$pet_id]);
        $pet = $p->fetch(PDO::FETCH_ASSOC);

        if (!$pet) {
            return ['ok' => false, 'message' => 'Pet not found'];
        }

        // Prevent duplicate active requests (Pending/Approved) for same adopter+pet
        $dup = $this->db->prepare("
            SELECT adoption_id, adoption_status
            FROM adoptions
            WHERE adopter_id = ? AND pet_id = ?
            ORDER BY adoption_id DESC
            LIMIT 1
        ");
        $dup->execute([$adopter_id, $pet_id]);
        $existing = $dup->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            $st = trim((string)($existing['adoption_status'] ?? ''));
            if (in_array($st, ['Pending', 'Approved'], true)) {
                return ['ok' => false, 'message' => 'You already have an active request for this pet'];
            }
        }

        $this->db->beginTransaction();
        try {
            // ✅ Insert into adoptions (MATCHES YOUR TABLE COLUMNS)
            $stmt = $this->db->prepare("
                INSERT INTO adoptions
                (pet_id, pet_name, adopter_id, shelter_id, adoption_status, requested_at, completed_at)
                VALUES (?, ?, ?, ?, 'Pending', NOW(), NULL)
            ");
            $stmt->execute([
                (int)$pet['pet_id'],
                (string)$pet['name'],
                $adopter_id,
                (int)$pet['shelter_id']
            ]);

            $adoptionId = (int)$this->db->lastInsertId();

            // ✅ Insert into adoption_request_details (if exists)
            if ($this->hasRequestDetails()) {
                // NOTE: Your SQL table should contain these columns:
                // adopter_id, username, full_name, address, phone, pet_id, created_at
                $stmt = $this->db->prepare("
                    INSERT INTO adoption_request_details
                    (adopter_id, username, full_name, address, phone, pet_id)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $adopter_id,
                    $username,
                    $full_name,
                    $address,
                    $phone,
                    $pet_id
                ]);
            }

            $this->db->commit();
            return ['ok' => true, 'message' => 'Request Sent'];
        } catch (Throwable $e) {
            $this->db->rollBack();
            return ['ok' => false, 'message' => 'Failed to create request'];
        }
    }

 
 public function listByUser(int $adopter_id): array
{
    $stmt = $this->db->prepare("
        SELECT
            a.adoption_id AS request_id,
            a.adoption_status AS status,
            a.requested_at AS created_at,
            a.pet_id,
            COALESCE(p.name, a.pet_name) AS name
        FROM adoptions a
        LEFT JOIN pets p ON p.pet_id = a.pet_id
        WHERE a.adopter_id = ?
        ORDER BY a.adoption_id DESC
    ");
    $stmt->execute([$adopter_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}
    public function canComplete(int $adopter_id, int $request_id): bool
    {
        $stmt = $this->db->prepare("
            SELECT adoption_id
            FROM adoptions
            WHERE adoption_id = ?
              AND adopter_id = ?
              AND adoption_status = 'Approved'
            LIMIT 1
        ");
        $stmt->execute([$request_id, $adopter_id]);
        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function completeAdoption(int $adopter_id, int $request_id): array
    {
        if (!$this->canComplete($adopter_id, $request_id)) {
            return ['ok' => false, 'message' => 'This request cannot be completed'];
        }

        $this->db->beginTransaction();
        try {
            // Mark request completed
            $stmt = $this->db->prepare("
                UPDATE adoptions
                SET adoption_status = 'Completed',
                    completed_at = NOW()
                WHERE adoption_id = ?
                  AND adopter_id = ?
            ");
            $stmt->execute([$request_id, $adopter_id]);

            // Mark pet adopted
            $stmt = $this->db->prepare("
                UPDATE pets p
                JOIN adoptions a ON a.pet_id = p.pet_id
                SET p.adoption_status = 'Adopted'
                WHERE a.adoption_id = ?
            ");
            $stmt->execute([$request_id]);

            $this->db->commit();
            return ['ok' => true, 'message' => 'Adoption completed. Congrats!'];
        } catch (Throwable $e) {
            $this->db->rollBack();
            return ['ok' => false, 'message' => 'Failed to complete adoption'];
        }
    }
}
