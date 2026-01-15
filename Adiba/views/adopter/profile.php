<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>
<h2>My Profile</h2>

<p>Name: <?php echo $profile['full_name']; ?></p>
<p>Email: <?php echo $profile['email']; ?></p>
<p>Phone: <?php echo $profile['phone']; ?></p>

<a href="../AdopterController.php?action=edit_profile">Edit Profile</a>
<button onclick="deleteProfile()">Delete Profile</button>

<script>
function deleteProfile() {
    if(confirm("Are you sure?")) {
        fetch('../../ajax/delete_profile.php', {method: 'POST'})
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            if(data.status === 'success') window.location.href = '../../login.php';
        });
    }
}
</script>
</body>
</html>
