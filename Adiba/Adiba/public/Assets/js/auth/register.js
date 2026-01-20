(function () {
  const formIdMap = {
    login: 'loginForm',
    register: 'registerForm',
    forgot: 'forgotForm',
    reset: 'resetForm',
  };

  // detect page by filename-based hint (script is only included on its page)
  const scriptName = (document.currentScript && document.currentScript.src) || '';
  const key = Object.keys(formIdMap).find(k => scriptName.includes('/' + k + '.js')) || 'login';
  const form = document.getElementById(formIdMap[key]);
  const msg = document.getElementById('msg');
  if (!form) return;

  function setMsg(text, ok) {
    if (!msg) return;
    msg.textContent = text || '';
    msg.className = 'FormMessage ' + (ok ? 'Ok' : 'Err');
  }

  async function readJsonSafe(res) {
    const ct = (res.headers.get('content-type') || '').toLowerCase();
    if (ct.includes('application/json')) {
      return await res.json();
    }
    const txt = await res.text();
    return { success: false, message: txt ? txt.slice(0, 300) : 'Unexpected response' };
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    setMsg('', true);

    const csrf = (form.csrf && form.csrf.value) ? form.csrf.value : '';

    // Build payload by form type
    let endpoint = '';
    let payload = { csrf };

    if (key === 'login') {
      endpoint = '/api/auth/login';
      const email = form.email.value.trim();
      const password = form.password.value;
      if (!email || !password) return setMsg('Please enter email and password.', false);
      payload.email = email;
      payload.password = password;
    }

    if (key === 'register') {
      endpoint = '/api/auth/register';
      const full_name = form.full_name.value.trim();
      const username = form.username.value.trim();
      const email = form.email.value.trim();
      const phone = form.phone.value.trim();
      const password = form.password.value;
      if (!full_name || !username || !email || !phone || !password) {
        return setMsg('Please fill in all fields.', false);
      }
      payload = { ...payload, full_name, username, email, phone, password };
    }

    if (key === 'forgot') {
      endpoint = '/api/auth/requestReset';
      const email = form.email.value.trim();
      if (!email) return setMsg('Please enter your email.', false);
      payload.email = email;
    }

    if (key === 'reset') {
      endpoint = '/api/auth/resetPassword';
      const email = (form.email && form.email.value) ? form.email.value.trim() : '';
      const token = (form.token && form.token.value) ? form.token.value.trim() : '';
      const password = form.password.value;
      if (!email || !token || !password) return setMsg('Please fill in all fields.', false);
      payload = { ...payload, email, token, password };
    }

    try {
      const res = await fetch((window.__BASE__ || '') + endpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify(payload),
      });

      const data = await readJsonSafe(res);

      if (!res.ok || !data.success) {
        setMsg(data.message || ('Request failed (' + res.status + ')'), false);
        return;
      }

      // forgot page: show reset link if present
      if (key === 'forgot' && data.reset_link) {
        setMsg((data.message || 'Reset link generated.') + '  ' + data.reset_link, true);
        return;
      }

      if (data.redirect) {
        window.location.href = data.redirect;
        return;
      }

      setMsg(data.message || 'Done.', true);
    } catch (err) {
      setMsg('Network error: ' + (err && err.message ? err.message : 'Please try again.'), false);
    }
  });
})();
