<?php
class ShelterPetsController extends Controller {

  public function index(): void {
    Auth::requireRole('shelter');
    $this->view('shelter/pets');
  }

  public function list(): void {
    Auth::requireRole('shelter');
    $pets = Pet::listByShelter(Auth::userId());
    $this->jsonOk(['pets' => $pets]);
  }

  private function validatePet(array $in): array {
    $name = trim($in['name'] ?? '');
    $species = trim($in['species'] ?? '');
    $breed = trim($in['breed'] ?? '');
    $age = (int)($in['age_years'] ?? -1);
    $gender = $in['gender'] ?? '';
    $location = trim($in['location'] ?? '');
    $personality = trim($in['personality'] ?? '');
    $rescued_on = trim($in['rescued_on'] ?? '');
    $rescued_by = trim($in['rescued_by'] ?? '');
    $health = $in['health_status'] ?? 'Vaccinated';
    $fee = $in['adoption_fee'] ?? null;
    $status = $in['adoption_status'] ?? 'Available';

    if ($species === '' || $breed === '') return ['ok'=>false,'msg'=>'Species and breed are required'];
    if ($age < 0 || $age > 40) return ['ok'=>false,'msg'=>'Age must be 0-40'];
    if (!in_array($gender, ['Male','Female'], true)) return ['ok'=>false,'msg'=>'Gender invalid'];
    if (!in_array($health, ['Vaccinated','Not Vaccinated','Under Treatment'], true)) return ['ok'=>false,'msg'=>'Health status invalid'];
    if (!in_array($status, ['Available','Pending','Adopted'], true)) return ['ok'=>false,'msg'=>'Adoption status invalid'];

    if ($fee !== null && $fee !== '') {
      if (!is_numeric($fee) || (float)$fee < 0) return ['ok'=>false,'msg'=>'Adoption fee invalid'];
    } else {
      $fee = null;
    }

    // allow empty date
    if ($rescued_on !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $rescued_on)) {
      return ['ok'=>false,'msg'=>'Rescued on must be YYYY-MM-DD'];
    }

    return [
      'ok'=>true,
      'data'=>[
        'name'=>$name,
        'species'=>$species,
        'breed'=>$breed,
        'age_years'=>$age,
        'gender'=>$gender,
        'location'=>$location,
        'personality'=>$personality,
        'rescued_on'=>$rescued_on === '' ? null : $rescued_on,
        'rescued_by'=>$rescued_by,
        'health_status'=>$health,
        'adoption_fee'=>$fee === null ? null : (float)$fee,
        'adoption_status'=>$status
      ]
    ];
  }

  /**
   * Save pet image to folder only (no DB column).
   * Stored as: public/uploads/pets/pet_<pet_id>.<jpg|png>
   */
  private function savePetImage(int $petId): ?string {
    if (!isset($_FILES['pet_image']) || $_FILES['pet_image']['error'] === UPLOAD_ERR_NO_FILE) return null;

    $f = $_FILES['pet_image'];
    if ($f['error'] !== UPLOAD_ERR_OK) return null;
    if ($f['size'] > MAX_UPLOAD_BYTES) return null;

    $info = getimagesize($f['tmp_name']);
    if ($info === false) return null;

    $mime = $info['mime'] ?? '';
    if (!in_array($mime, ['image/jpeg', 'image/png'], true)) return null;

    if (!is_dir(UPLOAD_DIR_PETS)) mkdir(UPLOAD_DIR_PETS, 0777, true);

    $ext = ($mime === 'image/png') ? 'png' : 'jpg';
    $target = UPLOAD_DIR_PETS . "pet_{$petId}.{$ext}";

    if (!move_uploaded_file($f['tmp_name'], $target)) return null;

    // return relative path for convenience
    return "/uploads/pets/pet_{$petId}.{$ext}";
  }

  public function create(): void {
    Auth::requireRole('shelter');

    $v = $this->validatePet($_POST);
    if (!$v['ok']) $this->jsonFail($v['msg']);

    $data = $v['data'];
    $data['shelter_id'] = Auth::userId();

    try {
      $id = Pet::create($data);
    } catch (PDOException $e) {
      // ✅ Return a readable error so you can see why INSERT fails (dev-friendly)
      $this->jsonFail('DB insert failed: ' . $e->getMessage(), 500);
    }

    // optional image (folder-only)
    if (isset($_FILES['pet_image']) && $_FILES['pet_image']['error'] !== UPLOAD_ERR_NO_FILE) {
      $saved = $this->savePetImage($id);
      if ($saved === null) {
        $this->jsonFail("Pet image invalid (only JPG/PNG, max 5MB)");
      }
    }
    ActivityLog::add('system', "Pet ID {$id} created", Auth::userId());
    $this->jsonOk(['pet_id' => $id]);
  }

  public function update(): void {
    Auth::requireRole('shelter');
    $petId = (int)($_POST['pet_id'] ?? 0);
    if ($petId <= 0) $this->jsonFail("Invalid pet_id");

    if (!Pet::getById($petId, Auth::userId())) $this->jsonFail("Pet not found", 404);

    $v = $this->validatePet($_POST);
    if (!$v['ok']) $this->jsonFail($v['msg']);

    $data = $v['data'];

    Pet::update($petId, Auth::userId(), $data);

    // optional image (folder-only)
    if (isset($_FILES['pet_image']) && $_FILES['pet_image']['error'] !== UPLOAD_ERR_NO_FILE) {
      $saved = $this->savePetImage($petId);
      if ($saved === null) {
        $this->jsonFail("Pet image invalid (only JPG/PNG, max 5MB)");
      }
    }
    ActivityLog::add('system', "Pet ID {$petId} updated", Auth::userId());
    $this->jsonOk();
  }

  public function delete(): void {
    Auth::requireRole('shelter');
    $petId = (int)($_POST['pet_id'] ?? 0);
    if ($petId <= 0) $this->jsonFail("Invalid pet_id");

    if (!Pet::getById($petId, Auth::userId())) $this->jsonFail("Pet not found", 404);

    Pet::delete($petId, Auth::userId());
    ActivityLog::add('system', "Pet ID {$petId} removed", Auth::userId());
    $this->jsonOk();
  }
}
