<?php
class ActivityLog {
  public static function add(string $category, string $description, ?int $performedBy): void {
    $db = Database::conn();
    $stmt = $db->prepare("INSERT INTO activity_log(category, description, performed_by) VALUES(?,?,?)");
    $stmt->execute([$category, $description, $performedBy]);
  }
}
