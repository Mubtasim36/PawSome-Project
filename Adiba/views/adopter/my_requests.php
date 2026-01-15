<!DOCTYPE html>
<html>
<head>
    <title>My Requests</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
<h2>My Adoption Requests</h2>

<table id="requestTable" border="1">
    <tr>
        <th>Pet Name</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
</table>

<script>
fetch('../../ajax/load_requests.php')
.then(res => res.json())
.then(data => {
    let table = document.getElementById('requestTable');
    data.forEach(req => {
        let row = table.insertRow();
        row.insertCell(0).innerText = req.pet_name;
        row.insertCell(1).innerText = req.adoption_status;
        let actionCell = row.insertCell(2);

        if(req.adoption_status === 'Approved') {
            let btn = document.createElement('button');
            btn.innerText = "Complete Adoption";
            btn.onclick = () => completeAdoption(req.adoption_id, req.pet_id);
            actionCell.appendChild(btn);
        } else {
            actionCell.innerText = "-";
        }
    });
});

function completeAdoption(adoptionId, petId) {
    fetch('../../ajax/complete_adoption.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({adoption_id: adoptionId, pet_id: petId})
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        location.reload();
    });
}
</script>

</body>
</html>
