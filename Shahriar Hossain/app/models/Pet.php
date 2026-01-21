<?php
class Pet {
  public static function listByShelter(int $shelterId): array {
    $db = Database::conn();
    $stmt = $db->prepare("SELECT * FROM pets WHERE shelter_id=? ORDER BY pet_id DESC");
    $stmt->execute([$shelterId]);
    return $stmt->fetchAll();
  }

  public static function getById(int $petId, int $shelterId): ?array {
    $db = Database::conn();
    $stmt = $db->prepare("SELECT * FROM pets WHERE pet_id=? AND shelter_id=?");
    $stmt->execute([$petId, $shelterId]);
    $row = $stmt->fetch();
    return $row ?: null;
  }

  /**
   * Create pet using ONLY columns that exist in your provided `pets` table.
   * (No image column is used; images are stored in folders.)
   */
  public static function create(array $data): int {
    $db = Database::conn();
    $stmt = $db->prepare("
      INSERT INTO pets
      (shelter_id, name, species, breed, age_years, gender, location, personality, rescued_on, rescued_by, health_status, adoption_fee, adoption_status)
      VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)
    ");

    $stmt->execute([
      $data['shelter_id'],
      $data['name'],
      $data['species'],
      $data['breed'],
      $data['age_years'],
      $data['gender'],
      $data['location'],
      $data['personality'],
      $data['rescued_on'],
      $data['rescued_by'],
      $data['health_status'],
      $data['adoption_fee'],
      $data['adoption_status'],
    ]);

    return (int)$db->lastInsertId();
  }

  public static function update(int $petId, int $shelterId, array $data): bool {
    $db = Database::conn();
    $stmt = $db->prepare("
      UPDATE pets SET
        name=?,
        species=?,
        breed=?,
        age_years=?,
        gender=?,
        location=?,
        personality=?,
        rescued_on=?,
        rescued_by=?,
        health_status=?,
        adoption_fee=?,
        adoption_status=?
      WHERE pet_id=? AND shelter_id=?
    ");

    return $stmt->execute([
      $data['name'],
      $data['species'],
      $data['breed'],
      $data['age_years'],
      $data['gender'],
      $data['location'],
      $data['personality'],
      $data['rescued_on'],
      $data['rescued_by'],
      $data['health_status'],
      $data['adoption_fee'],
      $data['adoption_status'],
      $petId,
      $shelterId
    ]);
  }

  public static function delete(int $petId, int $shelterId): bool {
    $db = Database::conn();
    $stmt = $db->prepare("DELETE FROM pets WHERE pet_id=? AND shelter_id=?");
    return $stmt->execute([$petId, $shelterId]);
  }
}
