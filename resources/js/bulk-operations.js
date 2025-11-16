/**
 * Модуль массовых операций с задачами
 * Позволяет выбирать несколько задач и применять к ним операции одновременно
 */

class BulkOperations {
    constructor() {
        this.selectedTasks = new Set();
        this.init();
    }

    init() {
        this.renderBulkControls();
        this.attachEventListeners();
    }

    /**
     * Отрисовка панели управления массовыми операциями
     */
    renderBulkControls() {
        const tasksContainer = document.querySelector('[data-tasks-container]');
        if (!tasksContainer) return;

        const bulkPanel = document.createElement('div');
        bulkPanel.id = 'bulk-operations-panel';
        bulkPanel.className = 'fixed bottom-6 left-1/2 -translate-x-1/2 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 p-4 transition-all duration-300 opacity-0 pointer-events-none z-50';
        bulkPanel.innerHTML = `
            <div class="flex items-center gap-4">
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    <span id="bulk-selected-count">0</span> выбрано
                </div>
                <div class="flex gap-2">
                    <button onclick="window.bulkOps.completeSelected()" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all text-sm font-medium flex items-center gap-2"
                            title="Отметить как выполненные">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Выполнить
                    </button>
                    <button onclick="window.bulkOps.changePriority()" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all text-sm font-medium flex items-center gap-2"
                            title="Изменить приоритет">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        Приоритет
                    </button>
                    <button onclick="window.bulkOps.deleteSelected()" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all text-sm font-medium flex items-center gap-2"
                            title="Удалить выбранные">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Удалить
                    </button>
                    <button onclick="window.bulkOps.clearSelection()" 
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all text-sm font-medium"
                            title="Снять выделение">
                        Отмена
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(bulkPanel);
    }

    /**
     * Привязка обработчиков событий
     */
    attachEventListeners() {
        // Добавляем чекбоксы к каждой задаче
        document.addEventListener('DOMContentLoaded', () => {
            this.addCheckboxesToTasks();
        });

        // Обработчик для "Выбрать все"
        document.addEventListener('click', (e) => {
            if (e.target.closest('[data-select-all-tasks]')) {
                e.preventDefault();
                this.selectAll();
            }
        });
    }

    /**
     * Добавление чекбоксов к задачам
     */
    addCheckboxesToTasks() {
        const tasks = document.querySelectorAll('[data-task-id]');
        
        tasks.forEach(taskElement => {
            const taskId = taskElement.dataset.taskId;
            
            // Проверяем, нет ли уже чекбокса
            if (taskElement.querySelector('.bulk-checkbox')) return;

            // Создаём чекбокс
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.className = 'bulk-checkbox w-5 h-5 text-indigo-600 border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 cursor-pointer';
            checkbox.dataset.taskId = taskId;
            
            // Обработчик изменения
            checkbox.addEventListener('change', () => {
                this.toggleTask(taskId, checkbox.checked);
            });

            // Добавляем чекбокс в начало карточки задачи
            const firstChild = taskElement.firstElementChild;
            if (firstChild) {
                const checkboxContainer = document.createElement('div');
                checkboxContainer.className = 'flex items-center mr-3';
                checkboxContainer.appendChild(checkbox);
                firstChild.insertBefore(checkboxContainer, firstChild.firstChild);
            }
        });
    }

    /**
     * Переключение выбора задачи
     */
    toggleTask(taskId, selected) {
        if (selected) {
            this.selectedTasks.add(taskId);
        } else {
            this.selectedTasks.delete(taskId);
        }
        this.updatePanel();
    }

    /**
     * Выбрать все задачи
     */
    selectAll() {
        const checkboxes = document.querySelectorAll('.bulk-checkbox');
        const allSelected = this.selectedTasks.size === checkboxes.length;

        checkboxes.forEach(checkbox => {
            checkbox.checked = !allSelected;
            this.toggleTask(checkbox.dataset.taskId, !allSelected);
        });
    }

    /**
     * Снять выделение
     */
    clearSelection() {
        document.querySelectorAll('.bulk-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
        this.selectedTasks.clear();
        this.updatePanel();
    }

    /**
     * Обновление панели управления
     */
    updatePanel() {
        const panel = document.getElementById('bulk-operations-panel');
        const countElement = document.getElementById('bulk-selected-count');
        
        if (!panel || !countElement) return;

        countElement.textContent = this.selectedTasks.size;

        if (this.selectedTasks.size > 0) {
            panel.classList.remove('opacity-0', 'pointer-events-none');
            panel.classList.add('opacity-100', 'pointer-events-auto');
        } else {
            panel.classList.remove('opacity-100', 'pointer-events-auto');
            panel.classList.add('opacity-0', 'pointer-events-none');
        }
    }

    /**
     * Выполнить выбранные задачи
     */
    async completeSelected() {
        if (this.selectedTasks.size === 0) return;

        try {
            const response = await fetch('/tasks/bulk/complete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    task_ids: Array.from(this.selectedTasks)
                })
            });

            const data = await response.json();

            if (data.success) {
                if (window.toast) {
                    window.toast.success(data.message);
                }
                if (window.announceToScreenReader) {
                    window.announceToScreenReader(data.message);
                }
                setTimeout(() => window.location.reload(), 500);
            } else {
                if (window.toast) {
                    window.toast.error(data.message || 'Ошибка при выполнении операции');
                }
            }
        } catch (error) {
            console.error('Error completing tasks:', error);
            if (window.toast) {
                window.toast.error('Ошибка при выполнении операции');
            }
        }
    }

    /**
     * Изменить приоритет выбранных задач
     */
    async changePriority() {
        if (this.selectedTasks.size === 0) return;

        const priority = await this.showPriorityDialog();
        if (!priority) return;

        try {
            const response = await fetch('/tasks/bulk/priority', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    task_ids: Array.from(this.selectedTasks),
                    priority: priority
                })
            });

            const data = await response.json();

            if (data.success) {
                if (window.toast) {
                    window.toast.success(data.message);
                }
                if (window.announceToScreenReader) {
                    window.announceToScreenReader(data.message);
                }
                setTimeout(() => window.location.reload(), 500);
            } else {
                if (window.toast) {
                    window.toast.error(data.message || 'Ошибка при изменении приоритета');
                }
            }
        } catch (error) {
            console.error('Error changing priority:', error);
            if (window.toast) {
                window.toast.error('Ошибка при изменении приоритета');
            }
        }
    }

    /**
     * Диалог выбора приоритета
     */
    showPriorityDialog() {
        return new Promise((resolve) => {
            const priorities = {
                'high': 'Высокий',
                'medium': 'Средний',
                'low': 'Низкий'
            };

            const choice = prompt('Выберите приоритет:\n1 - Высокий\n2 - Средний\n3 - Низкий');
            
            if (choice === '1') resolve('high');
            else if (choice === '2') resolve('medium');
            else if (choice === '3') resolve('low');
            else resolve(null);
        });
    }

    /**
     * Удалить выбранные задачи
     */
    async deleteSelected() {
        if (this.selectedTasks.size === 0) return;

        if (!confirm(`Вы уверены, что хотите удалить ${this.selectedTasks.size} задач(и)?`)) {
            return;
        }

        try {
            const response = await fetch('/tasks/bulk/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    task_ids: Array.from(this.selectedTasks)
                })
            });

            const data = await response.json();

            if (data.success) {
                if (window.toast) {
                    window.toast.success(data.message);
                }
                if (window.announceToScreenReader) {
                    window.announceToScreenReader(data.message);
                }
                setTimeout(() => window.location.reload(), 500);
            } else {
                if (window.toast) {
                    window.toast.error(data.message || 'Ошибка при удалении задач');
                }
            }
        } catch (error) {
            console.error('Error deleting tasks:', error);
            if (window.toast) {
                window.toast.error('Ошибка при удалении задач');
            }
        }
    }
}

// Инициализация
if (typeof window !== 'undefined') {
    window.bulkOps = new BulkOperations();
}

export default BulkOperations;
