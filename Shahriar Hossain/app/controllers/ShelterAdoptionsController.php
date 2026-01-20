<?php
class ShelterAdoptionsController extends Controller {
  public function index(): void {
    Auth::requireRole('shelter');
    $this->view('shelter/adoptions');
  }

  public function list(): void {
    Auth::requireRole('shelter');
    $rows = Adoption::listByShelter(Auth::userId());
    $this->jsonOk(['adoptions' => $rows]);
  }

  public function updateStatus(): void {
    Auth::requireRole('shelter');

    $id = (int)($_POST['adoption_id'] ?? 0);
    $status = $_POST['adoption_status'] ?? '';

    if ($id <= 0) $this->jsonFail("Invalid adoption_id");
    if (!Adoption::updateStatus($id, Auth::userId(), $status)) {
      $this->jsonFail("Failed to update status");
    }

    ActivityLog::add('adoption', "Adoption {$id} set to {$status}", Auth::userId());
    $this->jsonOk();
  }
}
