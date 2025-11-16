class SmartFilters {
  constructor() {
    this.searchInput = null;
    this.filterSelect = null;
    this.prioritySelect = null;
    this.tagSelect = null;
    this.sortSelect = null;
    this.storageKey = 'todo_filters_preferences';
  }

  init() {
    this.searchInput = document.getElementById('search');
    this.filterSelect = document.getElementById('filter');
    this.prioritySelect = document.getElementById('priority');
    this.tagSelect = document.getElementById('tag');
    
    // Создать селект сортировки если его нет
    this.createSortSelect();
    
    // Загрузить сохранённые настройки
    this.loadPreferences();
    
    // Сохранять изменения
    this.attachListeners();
  }

  createSortSelect() {
    const filterForm = document.querySelector('form[action*="tasks"]');
    if (!filterForm) return;

    const filterGrid = filterForm.querySelector('.grid');
    if (!filterGrid) return;

    // Проверить, не создан ли уже
    if (document.getElementById('sort')) return;

    const sortContainer = document.createElement('div');
    sortContainer.innerHTML = `
      <label for="sort" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
        </svg>
        Сортировка
      </label>
      <select 
        name="sort" 
        id="sort"
        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-all dark:text-gray-100"
      >
        <option value="created_desc">Сначала новые</option>
        <option value="created_asc">Сначала старые</option>
        <option value="priority_desc">Высокий приоритет</option>
        <option value="priority_asc">Низкий приоритет</option>
        <option value="due_date_asc">По сроку ↑</option>
        <option value="due_date_desc">По сроку ↓</option>
        <option value="title_asc">А-Я</option>
        <option value="title_desc">Я-А</option>
      </select>
    `;

    filterGrid.appendChild(sortContainer);
    this.sortSelect = document.getElementById('sort');
  }

  loadPreferences() {
    try {
      const saved = localStorage.getItem(this.storageKey);
      if (!saved) return;

      const prefs = JSON.parse(saved);
      
      if (this.filterSelect && prefs.filter) {
        this.filterSelect.value = prefs.filter;
      }
      if (this.prioritySelect && prefs.priority) {
        this.prioritySelect.value = prefs.priority;
      }
      if (this.tagSelect && prefs.tag) {
        this.tagSelect.value = prefs.tag;
      }
      if (this.sortSelect && prefs.sort) {
        this.sortSelect.value = prefs.sort;
      }
      if (this.searchInput && prefs.search) {
        this.searchInput.value = prefs.search;
      }
    } catch (e) {
      console.error('Failed to load filter preferences:', e);
    }
  }

  savePreferences() {
    try {
      const prefs = {
        filter: this.filterSelect?.value || '',
        priority: this.prioritySelect?.value || '',
        tag: this.tagSelect?.value || '',
        sort: this.sortSelect?.value || '',
        search: this.searchInput?.value || '',
        timestamp: Date.now(),
      };
      localStorage.setItem(this.storageKey, JSON.stringify(prefs));
    } catch (e) {
      console.error('Failed to save filter preferences:', e);
    }
  }

  attachListeners() {
    [this.searchInput, this.filterSelect, this.prioritySelect, this.tagSelect, this.sortSelect].forEach(el => {
      if (el) {
        el.addEventListener('change', () => this.savePreferences());
      }
    });

    // Сохранять поиск с задержкой
    if (this.searchInput) {
      let searchTimeout;
      this.searchInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => this.savePreferences(), 500);
      });
    }
  }

  clearPreferences() {
    localStorage.removeItem(this.storageKey);
    if (this.searchInput) this.searchInput.value = '';
    if (this.filterSelect) this.filterSelect.value = 'all';
    if (this.prioritySelect) this.prioritySelect.value = '';
    if (this.tagSelect) this.tagSelect.value = '';
    if (this.sortSelect) this.sortSelect.value = 'created_desc';
  }
}

// Добавить кнопку сброса фильтров
function addResetButton() {
  const filterForm = document.querySelector('form[action*="tasks"]');
  if (!filterForm) return;

  const buttonContainer = filterForm.querySelector('.flex.gap-3');
  if (!buttonContainer) return;

  // Проверить, не создана ли уже
  if (buttonContainer.querySelector('[data-clear-filters]')) return;

  const clearBtn = document.createElement('button');
  clearBtn.type = 'button';
  clearBtn.setAttribute('data-clear-filters', '');
  clearBtn.className = 'inline-flex items-center gap-2 px-6 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all transform hover:-translate-y-0.5';
  clearBtn.innerHTML = `
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
    </svg>
    Очистить
  `;

  clearBtn.addEventListener('click', () => {
    const smartFilters = window.smartFiltersInstance;
    if (smartFilters) {
      smartFilters.clearPreferences();
    }
    window.location.href = window.location.pathname;
  });

  buttonContainer.insertBefore(clearBtn, buttonContainer.lastElementChild);
}

window.addEventListener('DOMContentLoaded', () => {
  // Инициализировать только на странице задач
  if (document.getElementById('filter') && document.querySelector('form[action*="tasks"]')) {
    const smartFilters = new SmartFilters();
    smartFilters.init();
    window.smartFiltersInstance = smartFilters;
    
    addResetButton();
  }
});
