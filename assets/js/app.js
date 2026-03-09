// Basic client-side helpers
function qs(sel){ return document.querySelector(sel); }

document.addEventListener('DOMContentLoaded', () => {
  // Simple required validation
  document.querySelectorAll('form[data-validate="required"]').forEach(form => {
    form.addEventListener('submit', (e) => {
      let missing = false;
      form.querySelectorAll('[required]').forEach(el => {
        if (!el.value.trim()) { missing = true; el.classList.add('invalid'); }
        else el.classList.remove('invalid');
      });
      if (missing) {
        e.preventDefault();
        showAlert('Please fill in all required fields.', 'error');
      }
    });
  });
});

function showAlert(msg, type='success') {
  const div = document.createElement('div');
  div.className = `alert ${type}`;
  div.textContent = msg;
  const container = document.querySelector('.container');
  if (container) {
    container.prepend(div);
    setTimeout(() => div.remove(), 4000);
  } else {
    alert(msg);
  }
}