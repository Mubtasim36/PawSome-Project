function setPMsg(text, ok){
  const el = document.getElementById("pmsg");
  el.style.color = ok ? "#008142" : "#c0392b";
  el.textContent = text;
}

document.getElementById("profileForm").addEventListener("submit", async (e)=>{
  e.preventDefault();

  const full = document.getElementById("full_name").value.trim();
  const phone = document.getElementById("phone").value.trim();

  if(full.length < 3) return setPMsg("Full name must be at least 3 characters", false);
  if(phone && phone.length < 6) return setPMsg("Phone looks too short", false);

  const f = document.getElementById("shelter_image").files[0];
  if(f){
    const okType = ["image/jpeg","image/png"].includes(f.type);
    if(!okType) return setPMsg("Image must be JPG/PNG", false);
    if(f.size > 5 * 1024 * 1024) return setPMsg("Image must be <= 5MB", false);
  }

  const fd = new FormData(document.getElementById("profileForm"));
  const res = await fetch(`${BASE_URL}/index.php?r=shelter/profile/update`, { method:"POST", body: fd });
  const json = await res.json();

  if(!json.ok) return setPMsg(json.message || "Update failed", false);
  setPMsg("Profile updated. Refresh page to see updated image.", true);
});
