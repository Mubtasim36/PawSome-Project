<?php
class Daycare {
  public static function listSlots(int $shelterId): array {
    $db = Database::conn();
    $stmt = $db->prepare("SELECT * FROM daycare_slots WHERE shelter_id=? ORDER BY slot_date DESC, start_time DESC");
    $stmt->execute([$shelterId]);
    return $stmt->fetchAll();
  }

  public static function createSlot(int $shelterId, string $date, string $start, string $end, int $capacity): bool {
    $db = Database::conn();
    $stmt = $db->prepare("
      INSERT INTO daycare_slots(shelter_id, slot_date, start_time, end_time, capacity)
      VALUES(?,?,?,?,?)
    ");
    return $stmt->execute([$shelterId, $date, $start, $end, $capacity]);
  }

  public static function deleteSlot(int $shelterId, int $slotId): bool {
    $db = Database::conn();
    $stmt = $db->prepare("DELETE FROM daycare_slots WHERE slot_id=? AND shelter_id=?");
    return $stmt->execute([$slotId, $shelterId]);
  }

  public static function listBookings(int $shelterId): array {
    $db = Database::conn();
    $stmt = $db->prepare("
      SELECT b.*,
             s.slot_date, s.start_time, s.end_time,
             p.name AS pet_name,
             u.full_name AS owner_name
      FROM daycare_bookings b
      JOIN daycare_slots s ON s.slot_id=b.slot_id
      JOIN pets p ON p.pet_id=b.pet_id
      JOIN users u ON u.user_id=b.owner_id
      WHERE b.shelter_id=?
      ORDER BY b.booking_id DESC
    ");
    $stmt->execute([$shelterId]);
    return $stmt->fetchAll();
  }

  public static function updateBookingStatus(int $shelterId, int $bookingId, string $status): bool {
    $allowed = ['Booked','CheckedIn','CheckedOut','Cancelled'];
    if (!in_array($status, $allowed, true)) return false;

    $db = Database::conn();

    $extra = "";
    if ($status === 'CheckedIn') $extra = ", checkin_at=NOW()";
    if ($status === 'CheckedOut') $extra = ", checkout_at=NOW()";

    $stmt = $db->prepare("UPDATE daycare_bookings SET status=? $extra WHERE booking_id=? AND shelter_id=?");
    return $stmt->execute([$status, $bookingId, $shelterId]);
  }

  public static function addLog(int $shelterId, int $bookingId, string $activity, ?string $health): bool {
    $db = Database::conn();
    $stmt = $db->prepare("INSERT INTO daycare_logs(booking_id, shelter_id, activity_notes, health_notes) VALUES(?,?,?,?)");
    return $stmt->execute([$bookingId, $shelterId, $activity, $health]);
  }

  public static function listLogs(int $shelterId, int $bookingId): array {
    $db = Database::conn();
    $stmt = $db->prepare("SELECT * FROM daycare_logs WHERE shelter_id=? AND booking_id=? ORDER BY log_id DESC");
    $stmt->execute([$shelterId, $bookingId]);
    return $stmt->fetchAll();
  }
}
