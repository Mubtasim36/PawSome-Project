(function () {
  const form = document.getElementById('changePwForm');
  const msg = document.getElementById('pwMsg');
  if (!form || !msg) return;

  function setMsg(text, ok) {
    msg.textContent = text || '';
    msg.className = 'FormMessage ' + (ok ? 'Ok' : 'Err');
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    setMsg('', true);

    const current_password = form.current_password.value;
    const new_password = form.new_password.value;
    const confirm_password = form.confirm_password.value;
    const csrf = form.csrf.value;

    if (!current_password || !new_password || !confirm_password) {
      setMsg('All fields are required.', false);
      return;
    }
    if (new_password.length < 6) {
      setMsg('New password must be at least 6 characters.', false);
      return;
    }
    if (new_password !== confirm_password) {
      setMsg('Passwords do not match.', false);
      return;
    }

    try {
      const res = await fetch(window.__BASE__ + '/api/adopter/changePassword', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ current_password, new_password, confirm_password, csrf })
      });
      const data = await res.json();
      if (!data.success) {
        setMsg(data.message || 'Failed to update password.', false);
        return;
      }
      setMsg(data.message || 'Password updated.', true);
      form.current_password.value = '';
      form.new_password.value = '';
      form.confirm_password.value = '';
    } catch (err) {
      setMsg('Network error. Please try again.', false);
    }
  });
})();
