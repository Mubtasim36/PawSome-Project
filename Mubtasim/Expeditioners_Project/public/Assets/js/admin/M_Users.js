(() => {
  const BASE = "/Expeditioners_Project/public"; // IMPORTANT for XAMPP subfolder
  const LIMIT = 10;

  let page = 1;
  let total = 0;

  const tbody = document.getElementById("usersTableBody");
  const showingText = document.getElementById("usersShowingText");
  const prevBtn = document.getElementById("prevBtn");
  const nextBtn = document.getElementById("nextBtn");

  function escapeHtml(s) {
    return String(s ?? "")
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }

  function setLoading() {
    tbody.innerHTML = `<tr><td colspan="6">Loading users...</td></tr>`;
    showingText.textContent = `Showing 0 out of 0`;
  }

  async function loadUsers(p) {
    setLoading();

    const url = `${BASE}/api/admin/users?page=${p}&limit=${LIMIT}`;

    let res;
    try {
      res = await fetch(url, { headers: { Accept: "application/json" } });
    } catch (e) {
      tbody.innerHTML = `<tr><td colspan="6">Failed to fetch users (network error)</td></tr>`;
      return;
    }

    // If server returns HTML (wrong route), JSON.parse will fail.
    let data;
    try {
      data = await res.json();
    } catch (e) {
      const text = await res.text();
      console.error("Expected JSON, got:", text);
      tbody.innerHTML = `<tr><td colspan="6">API did not return JSON. Check fetch URL.</td></tr>`;
      return;
    }

    if (!res.ok) {
      tbody.innerHTML = `<tr><td colspan="6">${escapeHtml(
        data.error || "API error"
      )}</td></tr>`;
      return;
    }

    total = Number(data.total ?? 0);
    page = Number(data.page ?? p);
    const users = Array.isArray(data.users) ? data.users : [];

    // render rows
    if (users.length === 0) {
      tbody.innerHTML = `<tr><td colspan="6">No users found.</td></tr>`;
    } else {
      tbody.innerHTML = users
        .map((u) => {
          const userId = Number(u.user_id ?? 0);
          const name = escapeHtml(u.full_name ?? "");
          const email = escapeHtml(u.email ?? "");
          const role = escapeHtml(u.role ?? "");
          const statusText = "Active";

          return `
          <tr>
            <td>${userId}</td>
            <td>${name}</td>
            <td>${email}</td>
            <td>${role.charAt(0).toUpperCase() + role.slice(1)}</td>
            <td class="StatusActive">${statusText}</td>
            <td class="ActionButtons">
              <a class="ViewBtn" href="${BASE}/admin/users/view?id=${encodeURIComponent(
            userId
          )}">View</a>

              <form method="POST" action="${BASE}/admin/users/role" style="display:inline;">
                <input type="hidden" name="user_id" value="${userId}">
                <button class="EditBtn" type="submit">Edit</button>
              </form>

              <form method="POST" action="${BASE}/admin/users/delete" style="display:inline;">
                <input type="hidden" name="user_id" value="${userId}">
                <button class="DisableBtn" type="submit" onclick="return confirm('Delete this user?')">Delete</button>
              </form>
            </td>
          </tr>
        `;
        })
        .join("");
    }

    const showing = Math.min(LIMIT, users.length);
    showingText.textContent = `Showing ${showing} out of ${total}`;

    // buttons
    prevBtn.disabled = page <= 1;
    nextBtn.disabled = page * LIMIT >= total;
  }

  prevBtn.addEventListener("click", () => {
    if (page > 1) loadUsers(page - 1);
  });

  nextBtn.addEventListener("click", () => {
    if (page * LIMIT < total) loadUsers(page + 1);
  });

  // initial
  loadUsers(1);
})();
