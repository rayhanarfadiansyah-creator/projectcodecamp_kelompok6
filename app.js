// GoGreen frontend + PHP API integration (vanilla JS)
const API = 'api';
async function apiRequest(path, options = {}) {
  const response = await fetch(`${API}/${path}`, {
    credentials: 'same-origin',
    headers: { 'Content-Type': 'application/json', ...(options.headers || {}) },
    ...options
  });
  const data = await response.json().catch(() => ({}));
  if (!response.ok || data.success === false) throw new Error(data.message || 'Permintaan gagal.');
  return data;
}
async function csrfHeaders() {
  const data = await apiRequest('auth/csrf.php');
  return { 'X-CSRF-Token': data.csrf };
}
document.addEventListener('DOMContentLoaded', () => {
  const password = document.querySelector('#password');
  const toggle = document.querySelector('#togglePassword');
  if (password && toggle) toggle.addEventListener('click', () => {
    const show = password.type === 'password'; password.type = show ? 'text' : 'password';
    toggle.textContent = show ? 'Sembunyikan' : 'Lihat';
    toggle.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
  });

  const form = document.querySelector('#loginForm');
  const notice = document.querySelector('#formNotice');
  if (form && notice) form.addEventListener('submit', async event => {
    event.preventDefault(); if (!form.reportValidity()) return;
    const button = form.querySelector('[type="submit"]'); if (button) button.disabled = true;
    notice.textContent = 'Sedang masuk...';
    try {
      const headers = await csrfHeaders();
      const data = await apiRequest('auth/login.php', { method: 'POST', headers, body: JSON.stringify({ email: form.email.value, password: form.password.value }) });
      notice.textContent = data.message;
      window.location.href = data.user.role === 'admin' ? 'admin.html' : 'Home2.html';
    } catch (error) { notice.textContent = error.message; }
    finally { if (button) button.disabled = false; }
  });

  const menuToggle = document.querySelector('#menuToggle'); const nav = document.querySelector('#mainNav');
  if (menuToggle && nav) {
    menuToggle.addEventListener('click', () => { const open = nav.classList.toggle('open'); menuToggle.setAttribute('aria-expanded', String(open)); menuToggle.textContent = open ? '×' : '☰'; });
    nav.querySelectorAll('a').forEach(link => link.addEventListener('click', () => { nav.classList.remove('open'); menuToggle.setAttribute('aria-expanded', 'false'); menuToggle.textContent = '☰'; }));
  }
  // Navbar compact effect used by the redesigned Home1 page, if present.
  const capsule = document.querySelector('#mainNav');
  if (capsule) {
    const update = () => document.body.classList.toggle('nav-compact', window.innerWidth > 768 && window.scrollY > 90);
    update(); window.addEventListener('scroll', update, { passive: true }); window.addEventListener('resize', update, { passive: true });
  }
});
