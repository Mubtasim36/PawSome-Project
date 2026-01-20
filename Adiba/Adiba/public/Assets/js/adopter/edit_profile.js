(function () {
  const form = document.getElementById('profileForm');
  const msg = document.getElementById('msg');
  if (!form || !msg) return;

  function setMsg(text, ok) {
    msg.textContent = text || '';
    msg.className = 'FormMessage ' + (ok ? 'Ok' : 'Err');
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    setMsg('', true);

    const full_name = form.full_name.value.trim();
    const username = form.username.value.trim();
    const phone = form.phone.value.trim();
    const csrf = form.csrf.value;

    if (!full_name || !username || !phone) {
      setMsg('All fields are required.', false);
      return;
    }

    try {
      const res = await fetch(window.__BASE__ + '/api/adopter/updateProfile', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ full_name, username, phone, csrf })
      });
      const data = await res.json();
      if (!data.success) {
        setMsg(data.message || 'Failed to update profile.', false);
        return;
      }
      setMsg(data.message || 'Profile updated.', true);
      setTimeout(() => {
        window.location.href = data.redirect || (window.__BASE__ + '/adopter/profile');
      }, 700);
    } catch (err) {
      setMsg('Network error. Please try again.', false);
    }
  });
})();
