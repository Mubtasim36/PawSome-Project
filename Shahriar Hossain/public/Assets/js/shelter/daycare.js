function setMsg(id, text, ok){
  const el = document.getElementById(id);
  el.style.color = ok ? "#008142" : "#c0392b";
  el.textContent = text;
}

async function loadSlots(){
  const res = await fetch(`${BASE_URL}/index.php?r=shelter/daycare/slots`);
  const json = await res.json();
  const wrap = document.getElementById("slotsList");
  wrap.innerHTML = "";

  if(!json.ok){ setMsg("dmsg", json.message || "Failed", false); return; }
  if(json.slots.length === 0){
    wrap.innerHTML = `<p class="small">No slots. Create one.</p>`;
    return;
  }

  json.slots.forEach(s=>{
    const div = document.createElement("div");
    div.className = "slotItem";
    div.innerHTML = `
      <div class="slotRow">
        <div>
          <b>${s.slot_date}</b>
          <div class="small">${s.start_time} - ${s.end_time} • Capacity: ${s.capacity}</div>
          <div class="small">Slot ID: ${s.slot_id}</div>
        </div>
        <button class="actionBtn" style="border-color:#c0392b;color:#c0392b;" onclick="deleteSlot(${s.slot_id})">Delete</button>
      </div>
    `;
    wrap.appendChild(div);
  });
}

async function deleteSlot(id){
  if(!confirm("Delete this slot?")) return;
  const fd = new FormData();
  fd.append("slot_id", id);
  const res = await fetch(`${BASE_URL}/index.php?r=shelter/daycare/slot/delete`, { method:"POST", body: fd });
  const json = await res.json();
  if(!json.ok){ setMsg("dmsg", json.message || "Delete failed", false); return; }
  setMsg("dmsg", "Slot deleted", true);
  loadSlots();
}

document.getElementById("slotForm").addEventListener("submit", async (e)=>{
  e.preventDefault();

  const date = document.getElementById("slot_date").value.trim();
  const start = document.getElementById("start_time").value.trim();
  const end = document.getElementById("end_time").value.trim();
  const cap = Number(document.getElementById("capacity").value);

  if(!/^\d{4}-\d{2}-\d{2}$/.test(date)) return setMsg("dmsg","Date must be YYYY-MM-DD", false);
  if(!/^\d{2}:\d{2}$/.test(start)) return setMsg("dmsg","Start must be HH:MM", false);
  if(!/^\d{2}:\d{2}$/.test(end)) return setMsg("dmsg","End must be HH:MM", false);
  if(!Number.isInteger(cap) || cap < 1 || cap > 50) return setMsg("dmsg","Capacity 1-50", false);

  const fd = new FormData(document.getElementById("slotForm"));
  const res = await fetch(`${BASE_URL}/index.php?r=shelter/daycare/slot/create`, { method:"POST", body: fd });
  const json = await res.json();
  if(!json.ok){ setMsg("dmsg", json.message || "Create failed", false); return; }

  setMsg("dmsg", "Slot created", true);
  document.getElementById("slotForm").reset();
  loadSlots();
});

async function loadBookings(){
  const res = await fetch(`${BASE_URL}/index.php?r=shelter/daycare/bookings`);
  const json = await res.json();
  const wrap = document.getElementById("bookingsList");
  wrap.innerHTML = "";

  if(!json.ok){ wrap.innerHTML = `<p class="small">Failed to load bookings.</p>`; return; }
  if(json.bookings.length === 0){
    wrap.innerHTML = `<p class="small">No bookings yet (bookings come from adopter side).</p>`;
    return;
  }

  let html = `<table><thead><tr>
    <th>ID</th><th>Date</th><th>Pet</th><th>Owner</th><th>Status</th><th>Action</th>
  </tr></thead><tbody>`;

  for(const b of json.bookings){
    html += `<tr>
      <td>${b.booking_id}</td>
      <td>${b.slot_date} <div class="small">${b.start_time}-${b.end_time}</div></td>
      <td>${b.pet_name}</td>
      <td>${b.owner_name}</td>
      <td>${b.status}</td>
      <td>
        <button class="actionBtn" onclick="bookingStatus(${b.booking_id},'CheckedIn')">Check-In</button>
        <button class="actionBtn" onclick="bookingStatus(${b.booking_id},'CheckedOut')">Check-Out</button>
        <button class="actionBtn" onclick="bookingStatus(${b.booking_id},'Cancelled')">Cancel</button>
      </td>
    </tr>`;
  }
  html += `</tbody></table>`;
  wrap.innerHTML = html;
}

async function bookingStatus(id, status){
  const fd = new FormData();
  fd.append("booking_id", id);
  fd.append("status", status);
  const res = await fetch(`${BASE_URL}/index.php?r=shelter/daycare/booking/status`, { method:"POST", body: fd });
  const json = await res.json();
  if(!json.ok){ setMsg("lmsg", json.message || "Failed", false); return; }
  setMsg("lmsg", `Booking ${id} => ${status}`, true);
  loadBookings();
}

document.getElementById("logForm").addEventListener("submit", async (e)=>{
  e.preventDefault();

  const bookingId = Number(document.getElementById("booking_id").value);
  const activity = document.getElementById("activity_notes").value.trim();
  const health = document.getElementById("health_notes").value.trim();

  if(!Number.isInteger(bookingId) || bookingId <= 0) return setMsg("lmsg","Booking ID invalid", false);
  if(activity.length < 5) return setMsg("lmsg","Activity notes too short", false);

  const fd = new FormData();
  fd.append("booking_id", bookingId);
  fd.append("activity_notes", activity);
  fd.append("health_notes", health);

  const res = await fetch(`${BASE_URL}/index.php?r=shelter/daycare/log/add`, { method:"POST", body: fd });
  const json = await res.json();
  if(!json.ok){ setMsg("lmsg", json.message || "Failed", false); return; }

  setMsg("lmsg","Log added", true);
  document.getElementById("activity_notes").value = "";
  document.getElementById("health_notes").value = "";
});

document.getElementById("viewLogsBtn").onclick = async ()=>{
  const bookingId = Number(document.getElementById("booking_id").value);
  if(!Number.isInteger(bookingId) || bookingId <= 0) return setMsg("lmsg","Booking ID required", false);

  const res = await fetch(`${BASE_URL}/index.php?r=shelter/daycare/logs&booking_id=${bookingId}`);
  const json = await res.json();
  const wrap = document.getElementById("logsList");
  wrap.innerHTML = "";

  if(!json.ok){ setMsg("lmsg", json.message || "Failed", false); return; }
  if(json.logs.length === 0){
    wrap.innerHTML = `<p class="small">No logs for booking ${bookingId}.</p>`;
    return;
  }

  json.logs.forEach(l=>{
    const div = document.createElement("div");
    div.className = "logItem";
    div.innerHTML = `
      <b>${l.created_at}</b>
      <div class="small"><b>Activity:</b> ${l.activity_notes}</div>
      <div class="small"><b>Health:</b> ${l.health_notes || "-"}</div>
    `;
    wrap.appendChild(div);
  });
};

document.getElementById("refreshSlots").onclick = loadSlots;
document.getElementById("refreshBookings").onclick = loadBookings;

loadSlots();
loadBookings();
