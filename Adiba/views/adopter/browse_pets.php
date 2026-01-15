<!DOCTYPE html>
<html>
<head>
    <title>Browse Pets</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
<h2>Available Pets</h2>

<?php foreach ($pets as $pet): ?>
    <div class="pet-card">
        <h3><?php echo $pet['name']; ?></h3>
        <p>Species: <?php echo $pet['species']; ?></p>
        <a href="../AdopterController.php?action=details&id=<?php echo $pet['pet_id']; ?>">View Details</a>
    </div>
<?php endforeach; ?>

</body>
</html>
