<!DOCTYPE html>
<html>
<head>
    <title>Adopter Dashboard</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
<h2>Welcome Adopter</h2>

<div class="card">
    <p><strong>Pets Adopted:</strong> <?php echo $data['pets_adopted']; ?></p>
    <p><strong>Adoption Requests:</strong> <?php echo $data['adoption_requested']; ?></p>
</div>

<a href="../AdopterController.php?action=browse">Browse Pets</a> |
<a href="../AdopterController.php?action=requests">My Requests</a> |
<a href="../AdopterController.php?action=profile">Profile</a>

</body>
</html>
