<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>
<h2>Edit Profile</h2>

<form id="editForm">
    <input type="text" name="full_name" value="<?php echo $profile['full_name']; ?>" required><br>
    <input type="email" name="email" value="<?php echo $profile['email']; ?>" required><br>
    <input type="text" name="phone" value="<?php echo $profile['phone']; ?>" required><br>
    <button type="submit">Update</button>
</form>

<script>
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch('../../ajax/update_profile.php', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if(data.status === 'success') window.location.href = '../AdopterController.php?action=profile';
    });
});
</script>
</body>
</html>
