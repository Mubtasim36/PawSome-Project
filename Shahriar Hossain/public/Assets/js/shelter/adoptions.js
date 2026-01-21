function badge(s){
  return `<span class="badge ${s}">${s}</span>`;
}

async function loadAdoptions(){
  const res = await fetch(`${BASE_URL}/index.php?r=shelter/adoptions/list`);
  const json = await res.json();
  const wrap = document.getElementById("adoptionsList");
  const msg = document.getElementById("amsg");
  msg.textContent = "";

  if(!json.ok){
    msg.textContent = json.message || "Failed";
    return;
  }

  const rows = json.adoptions;
  if(rows.length === 0){
    wrap.innerHTML = `<p class="small">No adoption requests yet.</p>`;
    return;
  }

  let html = `<table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Pet</th>
        <th>Adopter</th>
        <th>Status</th>
        <th>Requested</th>
        <th>Action</th>
      </tr>
    </thead><tbody>`;

  for(const a of rows){
    html += `<tr>
      <td>${a.adoption_id}</td>
      <td>${a.pet_name} <div class="small">${a.species} • ${a.breed}</div></td>
      <td>${a.adopter_name}<div class="small">${a.adopter_email}</div></td>
      <td>${badge(a.adoption_status)}</td>
      <td>${a.requested_at}</td>
      <td>
        <button class="actionBtn approve" onclick="setStatus(${a.adoption_id},'Approved')">Approve</button>
        <button class="actionBtn reject" onclick="setStatus(${a.adoption_id},'Rejected')">Reject</button>
        <button class="actionBtn complete" onclick="setStatus(${a.adoption_id},'Completed')">Complete</button>
      </td>
    </tr>`;
  }

  html += `</tbody></table>`;
  wrap.innerHTML = html;
}

async function setStatus(id, status){
  const fd = new FormData();
  fd.append("adoption_id", id);
  fd.append("adoption_status", status);

  const res = await fetch(`${BASE_URL}/index.php?r=shelter/adoptions/update`, { method:"POST", body: fd });
  const json = await res.json();
  const msg = document.getElementById("amsg");

  if(!json.ok){
    msg.style.color = "#c0392b";
    msg.textContent = json.message || "Update failed";
    return;
  }

  msg.style.color = "#008142";
  msg.textContent = `Updated adoption ${id} => ${status}`;
  loadAdoptions();
}

document.getElementById("refreshA").onclick = loadAdoptions;
loadAdoptions();
