/**
 * Модуль управления подзадачами (чек-листами)
 * Позволяет добавлять, редактировать и отслеживать выполнение подзадач
 */

class SubtaskManager {
    constructor() {
        this.currentTaskId = null;
        this.subtasks = [];
        this.init();
    }

    init() {
        // Привязываем обработчики
        this.attachEventListeners();
    }

    /**
     * Привязка обработчиков событий
     */
    attachEventListeners() {
        document.addEventListener('click', (e) => {
            // Открытие менеджера подзадач
            if (e.target.closest('[data-open-subtasks]')) {
                e.preventDefault();
                const taskId = e.target.closest('[data-open-subtasks]').dataset.openSubtasks;
                this.openManager(taskId);
            }

            // Добавление подзадачи
            if (e.target.closest('[data-add-subtask]')) {
                e.preventDefault();
                this.addSubtask();
            }

            // Переключение статуса подзадачи
            if (e.target.closest('[data-toggle-subtask]')) {
                const subtaskId = e.target.closest('[data-toggle-subtask]').dataset.toggleSubtask;
                this.toggleSubtask(subtaskId);
            }

            // Удаление подзадачи
            if (e.target.closest('[data-delete-subtask]')) {
                e.preventDefault();
                const subtaskId = e.target.closest('[data-delete-subtask]').dataset.deleteSubtask;
                this.deleteSubtask(subtaskId);
            }
        });

        // Enter для добавления подзадачи
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && e.target.id === 'subtask-input') {
                e.preventDefault();
                this.addSubtask();
            }
        });
    }

    /**
     * Открыть менеджер подзадач для задачи
     */
    async openManager(taskId) {
        this.currentTaskId = taskId;
        
        // Загружаем подзадачи
        await this.loadSubtasks();
        
        // Показываем модальное окно
        this.showModal();
    }

    /**
     * Загрузить подзадачи из API
     */
    async loadSubtasks() {
        try {
            const response = await fetch(`/tasks/${this.currentTaskId}/subtasks`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            });

            const data = await response.json();

            if (data.success) {
                this.subtasks = data.subtasks;
                this.renderSubtasks();
                this.updateProgress(data.progress);
            }
        } catch (error) {
            console.error('Error loading subtasks:', error);
            if (window.toast) {
                window.toast.error('Ошибка при загрузке подзадач');
            }
        }
    }

    /**
     * Показать модальное окно
     */
    showModal() {
        let modal = document.getElementById('subtasks-modal');
        
        if (!modal) {
            modal = this.createModal();
            document.body.appendChild(modal);
        }

        modal.classList.remove('hidden');
        
        // Фокус на input
        setTimeout(() => {
            document.getElementById('subtask-input')?.focus();
        }, 100);
    }

    /**
     * Создать модальное окно
     */
    createModal() {
        const modal = document.createElement('div');
        modal.id = 'subtasks-modal';
        modal.className = 'hidden fixed inset-0 z-50 overflow-y-auto';
        modal.innerHTML = `
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center">
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity bg-gray-900 dark:bg-black opacity-75" onclick="window.subtaskManager.closeModal()"></div>

                <!-- Modal -->
                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                Подзадачи (Чек-лист)
                            </h3>
                            <button onclick="window.subtaskManager.closeModal()" 
                                    class="text-white hover:text-gray-200 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Progress bar -->
                        <div class="mt-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-white opacity-90">Прогресс выполнения</span>
                                <span id="subtasks-progress-text" class="text-sm text-white font-semibold">0%</span>
                            </div>
                            <div class="w-full bg-white bg-opacity-30 rounded-full h-2">
                                <div id="subtasks-progress-bar" class="bg-white h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-6">
                        <!-- Add new subtask -->
                        <div class="mb-6">
                            <div class="flex gap-2">
                                <input 
                                    type="text" 
                                    id="subtask-input"
                                    placeholder="Добавить новую подзадачу..."
                                    class="flex-1 px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-all dark:text-gray-100"
                                >
                                <button 
                                    data-add-subtask
                                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all font-medium flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Добавить
                                </button>
                            </div>
                        </div>

                        <!-- Subtasks list -->
                        <div id="subtasks-list" class="space-y-2 max-h-96 overflow-y-auto"></div>

                        <!-- Empty state -->
                        <div id="subtasks-empty" class="hidden text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">Подзадачи не добавлены</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Создайте первую подзадачу для отслеживания прогресса</p>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 flex justify-end">
                        <button onclick="window.subtaskManager.closeModal()"
                                class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all font-medium">
                            Готово
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        return modal;
    }

    /**
     * Закрыть модальное окно
     */
    closeModal() {
        const modal = document.getElementById('subtasks-modal');
        if (modal) {
            modal.classList.add('hidden');
        }
        
        // Обновляем основной список задач
        window.location.reload();
    }

    /**
     * Отрисовка списка подзадач
     */
    renderSubtasks() {
        const container = document.getElementById('subtasks-list');
        const emptyState = document.getElementById('subtasks-empty');
        
        if (!container) return;

        if (this.subtasks.length === 0) {
            container.innerHTML = '';
            emptyState?.classList.remove('hidden');
            return;
        }

        emptyState?.classList.add('hidden');

        container.innerHTML = this.subtasks.map(subtask => `
            <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg group hover:bg-gray-100 dark:hover:bg-gray-600 transition-all">
                <input 
                    type="checkbox" 
                    ${subtask.completed ? 'checked' : ''}
                    data-toggle-subtask="${subtask.id}"
                    class="w-5 h-5 text-indigo-600 border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 cursor-pointer"
                >
                <span class="flex-1 text-gray-700 dark:text-gray-200 ${subtask.completed ? 'line-through opacity-60' : ''}">
                    ${this.escapeHtml(subtask.title)}
                </span>
                <button 
                    data-delete-subtask="${subtask.id}"
                    class="opacity-0 group-hover:opacity-100 text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-all p-1"
                    title="Удалить подзадачу">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        `).join('');
    }

    /**
     * Обновить прогресс-бар
     */
    updateProgress(progress) {
        const progressBar = document.getElementById('subtasks-progress-bar');
        const progressText = document.getElementById('subtasks-progress-text');
        
        if (progressBar) {
            progressBar.style.width = `${progress}%`;
        }
        
        if (progressText) {
            progressText.textContent = `${progress}%`;
        }
    }

    /**
     * Добавить новую подзадачу
     */
    async addSubtask() {
        const input = document.getElementById('subtask-input');
        const title = input?.value.trim();

        if (!title) return;

        try {
            const response = await fetch(`/tasks/${this.currentTaskId}/subtasks`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ title })
            });

            const data = await response.json();

            if (data.success) {
                this.subtasks.push(data.subtask);
                this.renderSubtasks();
                this.updateProgress(data.progress);
                input.value = '';
                
                if (window.toast) {
                    window.toast.success('Подзадача добавлена');
                }
            } else {
                if (window.toast) {
                    window.toast.error(data.message || 'Ошибка при добавлении подзадачи');
                }
            }
        } catch (error) {
            console.error('Error adding subtask:', error);
            if (window.toast) {
                window.toast.error('Ошибка при добавлении подзадачи');
            }
        }
    }

    /**
     * Переключить статус подзадачи
     */
    async toggleSubtask(subtaskId) {
        const subtask = this.subtasks.find(s => s.id == subtaskId);
        if (!subtask) return;

        try {
            const response = await fetch(`/tasks/${this.currentTaskId}/subtasks/${subtaskId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ completed: !subtask.completed })
            });

            const data = await response.json();

            if (data.success) {
                subtask.completed = data.subtask.completed;
                this.renderSubtasks();
                this.updateProgress(data.progress);
            }
        } catch (error) {
            console.error('Error toggling subtask:', error);
        }
    }

    /**
     * Удалить подзадачу
     */
    async deleteSubtask(subtaskId) {
        if (!confirm('Удалить эту подзадачу?')) return;

        try {
            const response = await fetch(`/tasks/${this.currentTaskId}/subtasks/${subtaskId}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            });

            const data = await response.json();

            if (data.success) {
                this.subtasks = this.subtasks.filter(s => s.id != subtaskId);
                this.renderSubtasks();
                this.updateProgress(data.progress);
                
                if (window.toast) {
                    window.toast.success('Подзадача удалена');
                }
            }
        } catch (error) {
            console.error('Error deleting subtask:', error);
            if (window.toast) {
                window.toast.error('Ошибка при удалении подзадачи');
            }
        }
    }

    /**
     * Экранирование HTML
     */
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Инициализация
if (typeof window !== 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        window.subtaskManager = new SubtaskManager();
    });
}

export default SubtaskManager;
