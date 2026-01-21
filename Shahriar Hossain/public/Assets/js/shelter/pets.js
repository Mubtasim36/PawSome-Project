function qs(id) {
  return document.getElementById(id);
}

function normalizePath(p) {
  if (!p) return "";
  return p.startsWith("/") ? p.slice(1) : p;
}

function showMsg(t, ok) {
  const el = qs("msg");
  el.style.color = ok ? "#008142" : "#c0392b";
  el.textContent = t;
}

function validateFront() {
  const species = qs("species").value.trim();
  const breed = qs("breed").value.trim();
  const age = Number(qs("age_years").value);
  const gender = qs("gender").value;

  if (!species || !breed) return "Species and breed required";
  if (Number.isNaN(age) || age < 0 || age > 40) return "Age must be 0-40";
  if (gender !== "Male" && gender !== "Female") return "Gender required";

  const f = qs("pet_image").files[0];
  if (f) {
    const okType = ["image/jpeg", "image/png"].includes(f.type);
    if (!okType) return "Image must be JPG/PNG";
    if (f.size > 5 * 1024 * 1024) return "Image must be <= 5MB";
  }
  return null;
}

async function loadPets() {
  const res = await fetch(`${BASE_URL}/index.php?r=shelter/pets/list`);
  const json = await res.json();
  if (!json.ok) return;

  const wrap = qs("petsList");
  wrap.innerHTML = "";

  json.pets.forEach((p) => {
    const div = document.createElement("div");
    div.className = "petItem";

    const img = document.createElement("img");
    img.className = "petThumb";

    const meta = document.createElement("div");
    meta.className = "petMeta";
    meta.innerHTML = `
      <b>${p.name || "(No name)"} </b>
      <div class="small">${p.species} • ${p.breed} • Age: ${p.age_years} • ${p.gender}</div>
      <div class="small">Status: ${p.adoption_status} • Health: ${p.health_status}</div>
    `;

    const actions = document.createElement("div");
    actions.className = "actionRow";

    const edit = document.createElement("button");
    edit.className = "smallBtn";
    edit.textContent = "Edit";
    edit.onclick = () => fillForm(p);

    const del = document.createElement("button");
    del.className = "smallBtn danger";
    del.textContent = "Delete";
    del.onclick = () => deletePet(p.pet_id);

    actions.appendChild(edit);
    actions.appendChild(del);
    meta.appendChild(actions);

    div.appendChild(img);
    div.appendChild(meta);
    wrap.appendChild(div);
  });
}

function fillForm(p) {
  qs("pet_id").value = p.pet_id;
  qs("name").value = p.name || "";
  qs("species").value = p.species || "";
  qs("breed").value = p.breed || "";
  qs("age_years").value = p.age_years || 0;
  qs("gender").value = p.gender || "";
  qs("location").value = p.location || "";
  qs("personality").value = p.personality || "";
  qs("rescued_on").value = p.rescued_on || "";
  qs("rescued_by").value = p.rescued_by || "";
  qs("health_status").value = p.health_status || "Vaccinated";
  qs("adoption_fee").value = p.adoption_fee || "";
  qs("adoption_status").value = p.adoption_status || "Available";

  showMsg("Editing pet ID " + p.pet_id, true);
}

function resetForm() {
  qs("petForm").reset();
  qs("pet_id").value = "";
  showMsg("", true);
}

async function deletePet(petId) {
  if (!confirm("Delete this pet?")) return;

  const fd = new FormData();
  fd.append("pet_id", petId);

  const res = await fetch(`${BASE_URL}/index.php?r=shelter/pets/delete`, {
    method: "POST",
    body: fd,
  });
  const json = await res.json();
  if (!json.ok) {
    showMsg(json.message || "Delete failed", false);
    return;
  }

  showMsg("Pet deleted", true);
  resetForm();
  loadPets();
}

qs("petForm").addEventListener("submit", async (e) => {
  e.preventDefault();
  const err = validateFront();
  if (err) {
    showMsg(err, false);
    return;
  }

  const fd = new FormData(qs("petForm"));
  const petId = qs("pet_id").value.trim();
  const route = petId ? "shelter/pets/update" : "shelter/pets/create";

  const res = await fetch(`${BASE_URL}/index.php?r=${route}`, {
    method: "POST",
    body: fd,
  });
  const json = await res.json();

  if (!json.ok) {
    showMsg(json.message || "Save failed", false);
    return;
  }
  showMsg("Saved successfully", true);
  resetForm();
  loadPets();
});

qs("resetBtn").onclick = resetForm;
qs("refreshBtn").onclick = loadPets;

loadPets();
