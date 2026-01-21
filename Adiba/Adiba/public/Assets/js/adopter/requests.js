(function () {
  const wrap = document.getElementById('requestsWrap');
  const reloadBtn = document.getElementById('reloadBtn');
  const csrf = String(window.__CSRF__ || '');

  if (!wrap) return;

  function esc(s) {
    return String(s)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function pill(status) {
    const st = String(status || '');
    const cls =
      st === 'Approved' ? 'PillApproved' :
      st === 'Completed' ? 'PillCompleted' :
      st === 'Rejected' ? 'PillRejected' :
      'PillPending';
    return `<span class="StatusPill ${cls}">${esc(st)}</span>`;
  }

  async function complete(request_id) {
    if (!confirm('Mark this adoption as Completed? This is only allowed for Approved requests.')) return;

    try {
      const res = await fetch(window.__BASE__ + '/api/adopter/completeAdoption', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ request_id, csrf })
      });
      const data = await res.json();
      if (!data.success) {
        alert(data.message || 'Failed to complete adoption');
        return;
      }
      alert(data.message || 'Completed');
      await load();
    } catch (e) {
      alert('Network error');
    }
  }

  async function load() {
    wrap.innerHTML = '<div class="Loading">Loading…</div>';
    try {
      const res = await fetch(window.__BASE__ + '/api/adopter/loadRequests');
      const data = await res.json();
      if (!data.success) {
        wrap.innerHTML = '<div class="EmptyState">Failed to load.</div>';
        return;
      }

      const rows = Array.isArray(data.data) ? data.data : [];
      if (rows.length === 0) {
        wrap.innerHTML = '<div class="EmptyState">No Requests Yet</div>';
        return;
      }

      // Requirement: show message exactly like
      // "Request for [pet name] is pending" (status from DB)
      const html = rows
        .map(r => {
          const st = String(r.status || 'Pending').trim().toLowerCase();
          const petName = String(r.name || '').trim();
          return `<div class="RequestLine">Request for <b>${esc(petName)}</b> is ${esc(st)}</div>`;
        })
        .join('');
      wrap.innerHTML = `<div class="RequestsList">${html}</div>`;

    } catch (e) {
      wrap.innerHTML = '<div class="EmptyState">Network error.</div>';
    }
  }

  if (reloadBtn) reloadBtn.addEventListener('click', load);

  load();
})();
