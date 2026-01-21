(function () {
  const form = document.getElementById('loginForm');
  const msg = document.getElementById('msg');
  if (!form) return;

  function setMsg(text, ok) {
    msg.textContent = text || '';
    msg.className = 'FormMessage ' + (ok ? 'Ok' : 'Err');
  }

  async function readResponse(res) {
    const ct = (res.headers.get('content-type') || '').toLowerCase();
    if (ct.includes('application/json')) {
      return await res.json();
    }
    const text = await res.text();
    return { _nonJson: true, text };
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    setMsg('', true);

    const email = form.email.value.trim();
    const password = form.password.value;
    const csrf = form.csrf.value;

    if (!email || !password) {
      setMsg('Please enter email and password.', false);
      return;
    }

    try {
      const res = await fetch(window.__BASE__ + '/api/auth/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ email, password, csrf }),
      });

      const data = await readResponse(res);

      if (data && data._nonJson) {
        setMsg('Server returned a non-JSON response. Open DevTools → Network to see details.', false);
        return;
      }

      if (!res.ok || !data.success) {
        setMsg((data && data.message) || 'Login failed.', false);
        return;
      }

      window.location.href = data.redirect;
    } catch (err) {
      setMsg('Network error: ' + (err && err.message ? err.message : 'Please try again.'), false);
    }
  });
})();
