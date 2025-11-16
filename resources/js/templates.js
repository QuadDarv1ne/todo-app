class TemplatesManager {
  constructor() {
    this.select = null;
    this.saveToggleBtn = null;
    this.savePanel = null;
    this.saveBtn = null;
    this.inputs = {};
  }

  init() {
    this.select = document.getElementById('template_select');
    this.saveToggleBtn = document.getElementById('toggle_save_template');
    this.savePanel = document.getElementById('save_template_panel');
    this.saveBtn = document.getElementById('save_template_button');
    this.inputs = {
      templateName: document.getElementById('template_name'),
      templateDueDays: document.getElementById('template_due_days'),
      title: document.getElementById('title'),
      description: document.getElementById('description'),
      dueDate: document.getElementById('due_date'),
      priority: document.getElementById('priority'),
      reminders: document.getElementById('reminders_enabled'),
    };

    if (this.select) {
      this.fetchTemplates();
      this.select.addEventListener('change', () => this.onApplyTemplate());
    }

    if (this.saveToggleBtn && this.savePanel) {
      this.saveToggleBtn.addEventListener('click', () => {
        this.savePanel.classList.toggle('hidden');
      });
    }

    if (this.saveBtn) {
      this.saveBtn.addEventListener('click', () => this.saveTemplate());
    }
  }

  async fetchTemplates() {
    try {
      const res = await fetch('/templates', { headers: { 'Accept': 'application/json' } });
      const data = await res.json();
      if (!data.success) return;
      this.populateSelect(data.templates || []);
    } catch (e) {
      console.error('Failed to load templates', e);
    }
  }

  populateSelect(templates) {
    if (!this.select) return;
    // Reset options
    this.select.innerHTML = '';
    const placeholder = document.createElement('option');
    placeholder.value = '';
    placeholder.textContent = '— Выберите шаблон —';
    this.select.appendChild(placeholder);

    templates.forEach(t => {
      const opt = document.createElement('option');
      opt.value = String(t.id);
      opt.textContent = t.name;
      this.select.appendChild(opt);
    });
  }

  async onApplyTemplate() {
    const id = this.select?.value;
    if (!id) return;

    try {
      const res = await fetch(`/templates/apply/${id}`, { headers: { 'Accept': 'application/json' } });
      const data = await res.json();
      if (!data.success) return;
      const payload = data.data || {};

      if (this.inputs.title && payload.title != null) this.inputs.title.value = payload.title;
      if (this.inputs.description && payload.description != null) this.inputs.description.value = payload.description;
      if (this.inputs.priority && payload.priority != null) this.inputs.priority.value = payload.priority;
      if (this.inputs.reminders && payload.reminders_enabled != null) this.inputs.reminders.checked = !!payload.reminders_enabled;
      if (this.inputs.dueDate && payload.due_date) this.inputs.dueDate.value = payload.due_date;
    } catch (e) {
      console.error('Failed to apply template', e);
      alert('Не удалось применить шаблон');
    }
  }

  async saveTemplate() {
    const name = (this.inputs.templateName?.value || '').trim();
    if (!name) {
      alert('Введите имя шаблона');
      this.inputs.templateName?.focus();
      return;
    }

    const payload = {
      name,
      title: this.inputs.title?.value || null,
      description: this.inputs.description?.value || null,
      priority: this.inputs.priority?.value || null,
      reminders_enabled: this.inputs.reminders?.checked ? 1 : 0,
      default_due_days: this.inputs.templateDueDays?.value ? parseInt(this.inputs.templateDueDays.value, 10) : null,
    };

    try {
      const res = await fetch('/templates', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify(payload),
      });
      const data = await res.json();
      if (data.success) {
        alert('Шаблон сохранён');
        // Refresh list
        this.fetchTemplates();
        // Hide panel
        this.savePanel?.classList.add('hidden');
        // Reset only name to avoid accidental duplicates
        if (this.inputs.templateName) this.inputs.templateName.value = '';
      } else {
        alert(data.message || 'Ошибка при сохранении шаблона');
      }
    } catch (e) {
      console.error('Failed to save template', e);
      alert('Ошибка при сохранении шаблона');
    }
  }
}

window.addEventListener('DOMContentLoaded', () => {
  // Инициализировать только если есть хотя бы один из элементов шаблонов
  if (document.getElementById('template_select') || 
      document.getElementById('createTemplateModal') ||
      document.getElementById('toggle_save_template')) {
    const tm = new TemplatesManager();
    tm.init();
  }
});
