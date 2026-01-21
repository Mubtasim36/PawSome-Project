<?php
public function submitRequest()
{
    $user = require_role('adopter');

    if (!verify_csrf($_POST['csrf'] ?? '')) {
        redirect('/adopter/browse-pets');
        return;
    }

    $petId = (int)($_POST['pet_id'] ?? 0);

    $fullName = trim($_POST['full_name'] ?? '');
    $address  = trim($_POST['address'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');

    if ($petId <= 0 || $fullName === '' || $address === '' || $phone === '') {
        $_SESSION['error'] = "All fields are required.";
        redirect('/adopter/request?pet_id=' . $petId);
        return;
    }

    // 1️⃣ insert into adoptions (workflow)
   // Fetch pet info first
$stmt = db()->prepare("
    SELECT pet_id, name, shelter_id
    FROM pets
    WHERE pet_id = ?
");
$stmt->execute([$petId]);
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pet) {
    throw new Exception("Pet not found");
}

// ✅ Correct insert (matches table exactly)
$stmt = db()->prepare("
    INSERT INTO adoptions
    (pet_id, pet_name, adopter_id, shelter_id, adoption_status, requested_at)
    VALUES (?, ?, ?, ?, 'Pending', NOW())
");

$stmt->execute([
    $pet['pet_id'],
    $pet['name'],
    $user['user_id'],
    $pet['shelter_id']
]);


    // 3️⃣ show confirmation
    redirect('/adopter/request-submitted');
}
