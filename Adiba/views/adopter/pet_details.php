<!DOCTYPE html>
<html>
<head>
    <title>Pet Details</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
<h2><?php echo $pet['name']; ?></h2>

<p>Breed: <?php echo $pet['breed']; ?></p>
<p>Age: <?php echo $pet['age_years']; ?></p>
<p>Personality: <?php echo $pet['personality']; ?></p>

<button onclick="sendRequest(<?php echo $pet['pet_id']; ?>)">Adopt</button>

<script>
function sendRequest(petId) {
    fetch('../../ajax/send_request.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({pet_id: petId})
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if(data.status === 'success') {
            window.location.href = '../AdopterController.php?action=requests';
        }
    });
}
</script>

</body>
</html>
