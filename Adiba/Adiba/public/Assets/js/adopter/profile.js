(function () {
  const deleteBtn = document.getElementById("deleteBtn");
  const msg = document.getElementById("msg");
  const csrf = String(window.__CSRF__ || "");

  if (!deleteBtn || !msg) return;

  function setMsg(text, ok) {
    msg.textContent = text || "";
    msg.className = "FormMessage " + (ok ? "Ok" : "Err");
  }
  document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("addProfilePicBtn");
    const input = document.getElementById("profilePicInput");

    if (!btn || !input) return;

    btn.addEventListener("click", () => input.click());

    input.addEventListener("change", () => {
      if (input.files && input.files.length > 0) {
        // auto submit form (same UX as admin)
        input.closest("form").submit();
      }
    });
  });
  deleteBtn.addEventListener("click", async () => {
    const ok = confirm(
      "Are you sure you want to permanently delete your account? This cannot be undone.",
    );
    if (!ok) return;

    deleteBtn.disabled = true;
    setMsg("", true);

    try {
      const res = await fetch(window.__BASE__ + "/api/adopter/deleteProfile", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ csrf }),
      });
      const data = await res.json();
      if (!data.success) {
        setMsg(data.message || "Failed to delete account.", false);
        return;
      }
      setMsg(data.message || "Account deleted. Redirecting…", true);
      setTimeout(() => {
        window.location.href = data.redirect || window.__BASE__ + "/auth/login";
      }, 700);
    } catch (e) {
      setMsg("Network error. Please try again.", false);
    } finally {
      deleteBtn.disabled = false;
    }
  });
})();
