<?php
class ShelterDashboardController extends Controller {
  public function index(): void {
    Auth::requireRole('shelter');
    $this->view('shelter/dashboard');
  }
}
