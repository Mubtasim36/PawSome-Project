<?php
class Adoption {
  public static function listByShelter(int $shelterId): array {
    $db = Database::conn();
    $stmt = $db->prepare("
      SELECT a.*,
             u.full_name AS adopter_name,
             u.email AS adopter_email,
             p.species, p.breed, p.adoption_status AS pet_status
      FROM adoptions a
      JOIN users u ON u.user_id = a.adopter_id
      JOIN pets p ON p.pet_id = a.pet_id
      WHERE a.shelter_id=? AND a.adoption_status='Pending'
      ORDER BY a.adoption_id DESC
    ");
    $stmt->execute([$shelterId]);
    return $stmt->fetchAll();
  }

  public static function updateStatus(int $adoptionId, int $shelterId, string $status): bool {
    $allowed = ['Pending','Approved','Rejected','Completed'];
    if (!in_array($status, $allowed, true)) return false;

    $db = Database::conn();
    $db->beginTransaction();

    // get row
    $stmt = $db->prepare("SELECT * FROM adoptions WHERE adoption_id=? AND shelter_id=?");
    $stmt->execute([$adoptionId, $shelterId]);
    $ad = $stmt->fetch();
    if (!$ad) {
      $db->rollBack();
      return false;
    }

    // update adoption
    $stmt2 = $db->prepare("UPDATE adoptions SET adoption_status=? WHERE adoption_id=? AND shelter_id=?");
    $stmt2->execute([$status, $adoptionId, $shelterId]);

    // sync pet status
    // Pending/Approved -> Pending
    // Rejected -> Available
    // Completed -> Adopted
    $petStatus = 'Available';
    if ($status === 'Pending' || $status === 'Approved') $petStatus = 'Pending';
    if ($status === 'Completed') $petStatus = 'Adopted';
    if ($status === 'Rejected') $petStatus = 'Available';

    $stmt3 = $db->prepare("UPDATE pets SET adoption_status=? WHERE pet_id=? AND shelter_id=?");
    $stmt3->execute([$petStatus, $ad['pet_id'], $shelterId]);

    $db->commit();
    return true;
  }
}
