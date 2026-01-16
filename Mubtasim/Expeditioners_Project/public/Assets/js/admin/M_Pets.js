(() => {
  const BASE = "/Expeditioners_Project/public";
  const LIMIT = 10;

  let page = 1;
  let total = 0;

  const tbody = document.getElementById("petsTableBody");
  const showingText = document.getElementById("petsShowingText");
  const prevBtn = document.getElementById("prevPetsBtn");
  const nextBtn = document.getElementById("nextPetsBtn");

  if (!tbody || !showingText || !prevBtn || !nextBtn) {
    console.error("Missing required elements:", {
      tbody,
      showingText,
      prevBtn,
      nextBtn,
    });
    return;
  }

  function escapeHtml(s) {
    return String(s ?? "")
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }

  function setRowMessage(msg) {
    tbody.innerHTML = `<tr><td colspan="9">${escapeHtml(msg)}</td></tr>`;
  }

  async function loadPets(p) {
    setRowMessage("Loading pets...");
    showingText.textContent = "Showing 0 out of 0";

    const url = `${BASE}/api/admin/pets?page=${p}&limit=${LIMIT}`;
    console.log("Fetching pets:", url);

    let res;
    try {
      res = await fetch(url, { headers: { Accept: "application/json" } });
    } catch (e) {
      console.error(e);
      setRowMessage("Network error fetching pets");
      return;
    }

    let data;
    try {
      data = await res.json();
    } catch (e) {
      const text = await res.text();
      console.error("Not JSON:", text);
      setRowMessage(
        "API did not return JSON (wrong route or PHP error output)"
      );
      return;
    }

    if (!res.ok) {
      setRowMessage(data.error || "API error");
      return;
    }

    total = Number(data.total ?? 0);
    page = Number(data.page ?? p);
    const pets = Array.isArray(data.pets) ? data.pets : [];

    if (pets.length === 0) {
      setRowMessage("No pets found.");
    } else {
      tbody.innerHTML = pets
        .map((pet) => {
          const petId = Number(pet.pet_id ?? 0);
          return `
          <tr>
            <td>${petId}</td>
            <td>${escapeHtml(pet.name)}</td>
            <td>${escapeHtml(pet.species)}</td>
            <td>${escapeHtml(pet.breed)}</td>
            <td>${escapeHtml(pet.age_years)} Years</td>
            <td>${escapeHtml(pet.health_status)}</td>
            <td>${escapeHtml(pet.adoption_status)}</td>
            <td>${escapeHtml(pet.shelter_id)}</td>
            <td class="ActionButtons">
              <a class="ViewBtn" href="${BASE}/pets/view?id=${encodeURIComponent(
            petId
          )}">View</a>
              <form method="POST" action="${BASE}/admin/pets/delete" style="display:inline;">
                <input type="hidden" name="pet_id" value="${petId}">
                <button class="DisableBtn" type="submit" onclick="return confirm('Remove this pet?')">Remove</button>
              </form>
            </td>
          </tr>
        `;
        })
        .join("");
    }

    showingText.textContent = `Showing ${Math.min(
      LIMIT,
      pets.length
    )} out of ${total}`;
    prevBtn.disabled = page <= 1;
    nextBtn.disabled = page * LIMIT >= total;
  }

  prevBtn.addEventListener("click", () => {
    if (page > 1) loadPets(page - 1);
  });

  nextBtn.addEventListener("click", () => {
    if (page * LIMIT < total) loadPets(page + 1);
  });

  loadPets(1);
})();
