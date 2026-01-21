(function () {
  const btn = document.getElementById('sendBtn');
  const msg = document.getElementById('msg');
  const noteEl = document.getElementById('note');

  if (!btn || !msg) return;

  function setMsg(text, ok) {
    msg.textContent = text || '';
    msg.className = 'FormMessage ' + (ok ? 'Ok' : 'Err');
  }

  btn.addEventListener('click', async function () {
    const pet_id = Number(window.__PET_ID__ || 0);
    const csrf = String(window.__CSRF__ || '');
    const note = (noteEl ? noteEl.value : '').trim();

    if (!pet_id) {
      setMsg('Invalid pet. Please go back and open the pet again.', false);
      return;
    }
    if (!csrf) {
      setMsg('Security token missing. Refresh the page and try again.', false);
      return;
    }

    btn.disabled = true;
    const oldText = btn.textContent;
    btn.textContent = 'Sending…';

    try {
      const res = await fetch(window.__BASE__ + '/api/adopter/sendRequest', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ pet_id, note, csrf })
      });
      const data = await res.json();
      if (!data.success) {
        setMsg(data.message || 'Failed to send request.', false);
        return;
      }
      setMsg(data.message || 'Adoption request sent.', true);
    } catch (e) {
      setMsg('Network error. Please try again.', false);
    } finally {
      btn.disabled = false;
      btn.textContent = oldText;
    }
  });
})();
