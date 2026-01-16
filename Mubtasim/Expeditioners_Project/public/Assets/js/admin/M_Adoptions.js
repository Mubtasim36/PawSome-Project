(() => {
  const BASE = "/Expeditioners_Project/public";
  const LIMIT = 10;

  let page = 1;
  let total = 0;

  const tbody = document.getElementById("adoptionsTableBody");
  const showingText = document.getElementById("adoptionsShowingText");
  const prevBtn = document.getElementById("prevBtn");
  const nextBtn = document.getElementById("nextBtn");

  if (!tbody || !showingText || !prevBtn || !nextBtn) {
    console.error("Missing required elements", {
      tbody,
      showingText,
      prevBtn,
      nextBtn,
    });
    return;
  }

  function escapeHtml(text) {
    return String(text ?? "")
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }

  function setRowMessage(msg) {
    tbody.innerHTML = `<tr><td colspan="7">${escapeHtml(msg)}</td></tr>`;
  }

  async function loadAdoptions(p) {
    setRowMessage("Loading adoptions...");
    showingText.textContent = "Showing 0 out of 0";

    const url = `${BASE}/api/admin/adoptions?page=${p}&limit=${LIMIT}`;
    console.log("Fetching adoptions:", url);

    let res;
    try {
      res = await fetch(url, { headers: { Accept: "application/json" } });
    } catch (e) {
      console.error(e);
      setRowMessage("Network error fetching adoptions");
      return;
    }

    let data;
    try {
      data = await res.json();
    } catch (e) {
      const text = await res.text();
      console.error("Not JSON:", text);
      setRowMessage("API did not return JSON");
      return;
    }

    if (!res.ok) {
      setRowMessage(data.error || "API error");
      return;
    }

    total = Number(data.total ?? 0);
    page = Number(data.page ?? p);
    const adoptions = Array.isArray(data.adoptions) ? data.adoptions : [];

    if (adoptions.length === 0) {
      setRowMessage("No adoptions found.");
    } else {
      tbody.innerHTML = adoptions
        .map((a) => {
          const id = Number(a.adoption_id);
          return `
          <tr>
            <td>${id}</td>
            <td>${escapeHtml(a.pet_name)}</td>
            <td>${escapeHtml(a.adopter_id)}</td>
            <td>${escapeHtml(a.shelter_id)}</td>
            <td class="Status${escapeHtml(a.adoption_status)}">
              ${escapeHtml(a.adoption_status)}
            </td>
            <td>${escapeHtml(a.requested_at)}</td>
            <td class="ActionButtons">
              <a class="ViewBtn"
                 href="${BASE}/admin/adoptions/view?id=${encodeURIComponent(
            id
          )}">
                View
              </a>
            </td>
          </tr>
        `;
        })
        .join("");
    }

    showingText.textContent = `Showing ${Math.min(
      LIMIT,
      adoptions.length
    )} out of ${total}`;

    prevBtn.disabled = page <= 1;
    nextBtn.disabled = page * LIMIT >= total;
  }

  prevBtn.addEventListener("click", () => {
    if (page > 1) loadAdoptions(page - 1);
  });

  nextBtn.addEventListener("click", () => {
    if (page * LIMIT < total) loadAdoptions(page + 1);
  });

  loadAdoptions(1);
})();
