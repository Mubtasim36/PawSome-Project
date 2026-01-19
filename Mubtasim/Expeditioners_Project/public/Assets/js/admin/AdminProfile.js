document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("addProfilePicBtn");
  const input = document.getElementById("profilePicInput");

  if (!btn || !input) {
    console.error("Profile upload elements not found");
    return;
  }

  btn.addEventListener("click", () => {
    input.click(); //THIS opens file picker
  });

  input.addEventListener("change", () => {
    const file = input.files[0];
    if (!file) return;

    const maxSize = 5 * 1024 * 1024;
    const allowed = ["image/jpeg", "image/png"];

    if (!allowed.includes(file.type)) {
      alert("Only JPEG or PNG allowed");
      input.value = "";
      return;
    }

    if (file.size > maxSize) {
      alert("File must be under 5MB");
      input.value = "";
      return;
    }

    //auto-submit form
    input.closest("form").submit();
  });
});
