document.addEventListener("DOMContentLoaded", async () => {
  try {
    const res = await fetch("/Expeditioners_Project/public/api/admin/stats");
    if (!res.ok) return;

    const data = await res.json();

    const c1 = document.querySelector(".Count1");
    const c2 = document.querySelector(".Count2");
    const c3 = document.querySelector(".Count3");

    if (c1) c1.textContent = data.users ?? 0;
    if (c2) c2.textContent = data.pets ?? 0;
    if (c3) c3.textContent = data.adoptions ?? 0;
  } catch (e) {
  }
});