(function () {
  const wrap = document.getElementById('recentRequests');
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
        // Requirement: show a simple empty state
        wrap.innerHTML = '<div class="EmptyState">No Requests Yet</div>';
        return;
      }

      // Requirement: show "Request [status]" for the latest request
      const latest = rows[0];
      wrap.innerHTML = `<div class="RecentStatus">Request ${pill(latest.status || 'Pending')}</div>`;
    } catch (e) {
      wrap.innerHTML = '<div class="EmptyState">Network error.</div>';
    }
  }

  load();
})();
