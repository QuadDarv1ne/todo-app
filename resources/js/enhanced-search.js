class EnhancedSearch {
  constructor() {
    this.searchInput = null;
    this.filterSelect = null;
    this.prioritySelect = null;
    this.tagSelect = null;
    this.tasksContainer = null;
    this.taskCards = [];
    this.debounceTimer = null;
  }

  init() {
    this.searchInput = document.getElementById('search');
    this.filterSelect = document.getElementById('filter');
    this.prioritySelect = document.getElementById('priority');
    this.tagSelect = document.getElementById('tag');
    this.tasksContainer = document.querySelector('[data-tasks-container]');

    if (!this.searchInput || !this.tasksContainer) return;

    // Cache task cards
    this.cacheTaskCards();

    // Instant search with debounce
    this.searchInput.addEventListener('input', () => {
      clearTimeout(this.debounceTimer);
      this.debounceTimer = setTimeout(() => {
        this.performSearch();
      }, 300);
    });

    // Real-time filtering
    if (this.filterSelect) {
      this.filterSelect.addEventListener('change', () => this.performSearch());
    }
    if (this.prioritySelect) {
      this.prioritySelect.addEventListener('change', () => this.performSearch());
    }
    if (this.tagSelect) {
      this.tagSelect.addEventListener('change', () => this.performSearch());
    }
  }

  cacheTaskCards() {
    const cards = this.tasksContainer.querySelectorAll('[data-task-id]');
    this.taskCards = Array.from(cards).map(card => ({
      element: card,
      id: card.getAttribute('data-task-id'),
      title: card.querySelector('.task-title')?.textContent.toLowerCase() || '',
      description: card.querySelector('p.text-sm')?.textContent.toLowerCase() || '',
      priority: this.extractPriority(card),
      completed: card.querySelector('.task-toggle')?.checked || false,
    }));
  }

  extractPriority(card) {
    const priorityBar = card.querySelector('.h-1\\.5');
    if (!priorityBar) return null;
    if (priorityBar.classList.contains('bg-red-500')) return 'high';
    if (priorityBar.classList.contains('bg-yellow-500')) return 'medium';
    if (priorityBar.classList.contains('bg-green-500')) return 'low';
    return null;
  }

  performSearch() {
    const query = (this.searchInput?.value || '').toLowerCase().trim();
    const filterValue = this.filterSelect?.value || 'all';
    const priorityValue = this.prioritySelect?.value || '';

    let visibleCount = 0;

    this.taskCards.forEach(task => {
      let visible = true;

      // Search filter
      if (query && !task.title.includes(query) && !task.description.includes(query)) {
        visible = false;
      }

      // Status filter
      if (filterValue === 'active' && task.completed) visible = false;
      if (filterValue === 'completed' && !task.completed) visible = false;

      // Priority filter
      if (priorityValue && task.priority !== priorityValue) visible = false;

      // Show/hide
      if (visible) {
        task.element.style.display = '';
        this.highlightText(task.element, query);
        visibleCount++;
      } else {
        task.element.style.display = 'none';
      }
    });

    this.updateResultsCount(visibleCount);
  }

  highlightText(element, query) {
    if (!query) {
      // Remove highlights
      const titleEl = element.querySelector('.task-title');
      if (titleEl) {
        titleEl.innerHTML = titleEl.textContent;
      }
      return;
    }

    const titleEl = element.querySelector('.task-title');
    if (titleEl) {
      const text = titleEl.textContent;
      const regex = new RegExp(`(${this.escapeRegex(query)})`, 'gi');
      const highlighted = text.replace(regex, '<mark class="bg-yellow-200 dark:bg-yellow-700 px-1 rounded">$1</mark>');
      titleEl.innerHTML = highlighted;
    }
  }

  escapeRegex(str) {
    return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  }

  updateResultsCount(count) {
    let countDisplay = document.getElementById('search-results-count');
    if (!countDisplay) {
      countDisplay = document.createElement('div');
      countDisplay.id = 'search-results-count';
      countDisplay.className = 'text-sm text-gray-600 dark:text-gray-400 mt-2';
      this.searchInput.parentElement.appendChild(countDisplay);
    }

    if (this.searchInput.value.trim()) {
      countDisplay.textContent = `Найдено: ${count}`;
      countDisplay.classList.remove('hidden');
    } else {
      countDisplay.classList.add('hidden');
    }
  }
}

window.addEventListener('DOMContentLoaded', () => {
  // Инициализировать только на странице с поиском
  if (document.getElementById('search') && document.querySelector('[data-tasks-container]')) {
    const search = new EnhancedSearch();
    search.init();
  }
});
