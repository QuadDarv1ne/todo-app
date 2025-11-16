document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('reminders-form');
  if (!form || !window.axios) return;
  const statusEl = document.getElementById('reminders-status');

  const setStatus = (msg, ok = true) => {
    if (statusEl) {
      statusEl.textContent = msg;
      statusEl.classList.toggle('text-green-600', ok);
      statusEl.classList.toggle('dark:text-green-400', ok);
      statusEl.classList.toggle('text-red-600', !ok);
      statusEl.classList.toggle('dark:text-red-400', !ok);
    }
    if (window.announceToScreenReader) window.announceToScreenReader(msg);
  };

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const fd = new FormData(form);
    const payload = {
      reminder_enabled: fd.get('reminder_enabled') ? true : false,
      reminder_1_day: fd.get('reminder_1_day') ? true : false,
      reminder_3_days: fd.get('reminder_3_days') ? true : false,
      reminder_1_week: fd.get('reminder_1_week') ? true : false,
      reminder_overdue: fd.get('reminder_overdue') ? true : false,
      reminder_time: fd.get('reminder_time') || null,
    };
    try {
      await window.axios.patch('/reminders', payload);
      setStatus('Настройки напоминаний сохранены');
      if (window.toast) window.toast.success('Настройки напоминаний сохранены');
    } catch (err) {
      setStatus('Не удалось сохранить настройки', false);
      if (window.toast) window.toast.error('Не удалось сохранить настройки');
    }
  });
});
