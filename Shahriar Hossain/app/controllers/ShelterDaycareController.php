<?php
class ShelterDaycareController extends Controller {

  public function index(): void {
    Auth::requireRole('shelter');
    $this->view('shelter/daycare');
  }

  public function slots(): void {
    Auth::requireRole('shelter');
    $this->jsonOk(['slots' => Daycare::listSlots(Auth::userId())]);
  }

  public function createSlot(): void {
    Auth::requireRole('shelter');

    $date = trim($_POST['slot_date'] ?? '');
    $start = trim($_POST['start_time'] ?? '');
    $end = trim($_POST['end_time'] ?? '');
    $cap = (int)($_POST['capacity'] ?? 0);

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) $this->jsonFail("Invalid date");
    if (!preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $start)) $this->jsonFail("Invalid start time");
    if (!preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $end)) $this->jsonFail("Invalid end time");
    if ($cap < 1 || $cap > 50) $this->jsonFail("Capacity must be 1-50");

    Daycare::createSlot(Auth::userId(), $date, substr($start,0,5), substr($end,0,5), $cap);
    ActivityLog::add('system', "Daycare slot created: {$date} {$start}-{$end}", Auth::userId());
    $this->jsonOk();
  }

  public function deleteSlot(): void {
    Auth::requireRole('shelter');
    $slotId = (int)($_POST['slot_id'] ?? 0);
    if ($slotId <= 0) $this->jsonFail("Invalid slot_id");

    Daycare::deleteSlot(Auth::userId(), $slotId);
    ActivityLog::add('system', "Daycare slot deleted: {$slotId}", Auth::userId());
    $this->jsonOk();
  }

  public function bookings(): void {
    Auth::requireRole('shelter');
    $this->jsonOk(['bookings' => Daycare::listBookings(Auth::userId())]);
  }

  public function bookingStatus(): void {
    Auth::requireRole('shelter');
    $bookingId = (int)($_POST['booking_id'] ?? 0);
    $status = $_POST['status'] ?? '';
    if ($bookingId <= 0) $this->jsonFail("Invalid booking_id");

    if (!Daycare::updateBookingStatus(Auth::userId(), $bookingId, $status)) {
      $this->jsonFail("Failed to update booking status");
    }
    ActivityLog::add('system', "Daycare booking {$bookingId} => {$status}", Auth::userId());
    $this->jsonOk();
  }

  public function addLog(): void {
    Auth::requireRole('shelter');

    $bookingId = (int)($_POST['booking_id'] ?? 0);
    $activity = trim($_POST['activity_notes'] ?? '');
    $health = trim($_POST['health_notes'] ?? '');

    if ($bookingId <= 0) $this->jsonFail("Invalid booking_id");
    if ($activity === '' || strlen($activity) < 5) $this->jsonFail("Activity notes too short");

    Daycare::addLog(Auth::userId(), $bookingId, $activity, $health === '' ? null : $health);
    ActivityLog::add('system', "Daycare log added for booking {$bookingId}", Auth::userId());
    $this->jsonOk();
  }

  public function logs(): void {
    Auth::requireRole('shelter');
    $bookingId = (int)($_GET['booking_id'] ?? 0);
    if ($bookingId <= 0) $this->jsonFail("Invalid booking_id");

    $this->jsonOk(['logs' => Daycare::listLogs(Auth::userId(), $bookingId)]);
  }
}
