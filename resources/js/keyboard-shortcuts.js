/**
 * Модуль горячих клавиш для управления задачами
 * Keyboard shortcuts для повышения продуктивности
 */

class KeyboardShortcuts {
    constructor() {
        this.shortcuts = {
            'n': () => this.openCreateTaskModal(),           // N - новая задача
            'f': () => this.focusSearch(),                   // F - фокус на поиске
            'a': () => this.selectAllTasks(),                // A - выбрать все
            'escape': () => this.closeModals(),              // ESC - закрыть модалы
            '/': () => this.showShortcutsHelp(),            // / - показать справку
        };

        this.ctrlShortcuts = {
            's': (e) => this.saveCurrentForm(e),            // Ctrl+S - сохранить
            'k': (e) => this.focusSearch(e),                // Ctrl+K - поиск
        };

        this.init();
    }

    init() {
        this.attachKeyboardListeners();
        this.createShortcutsHelpModal();
        this.showShortcutHints();
    }

    /**
     * Привязка обработчиков клавиатуры
     */
    attachKeyboardListeners() {
        document.addEventListener('keydown', (e) => {
            // Игнорируем, если фокус в поле ввода (кроме Escape)
            const isInputFocused = ['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName);
            
            if (isInputFocused && e.key !== 'Escape') {
                // Обрабатываем только Ctrl+S и Ctrl+K в полях ввода
                if ((e.ctrlKey || e.metaKey) && this.ctrlShortcuts[e.key]) {
                    this.ctrlShortcuts[e.key](e);
                }
                return;
            }

            // Обработка Ctrl/Cmd + клавиша
            if ((e.ctrlKey || e.metaKey) && this.ctrlShortcuts[e.key]) {
                e.preventDefault();
                this.ctrlShortcuts[e.key](e);
                return;
            }

            // Обработка обычных клавиш
            const key = e.key.toLowerCase();
            if (this.shortcuts[key]) {
                e.preventDefault();
                this.shortcuts[key]();
            }
        });
    }

    /**
     * Открыть модал создания задачи
     */
    openCreateTaskModal() {
        if (typeof window.openCreateTaskModal === 'function') {
            window.openCreateTaskModal();
            if (window.announceToScreenReader) {
                window.announceToScreenReader('Открыта форма создания задачи');
            }
        }
    }

    /**
     * Фокус на поле поиска
     */
    focusSearch(e) {
        if (e) e.preventDefault();
        
        const searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.focus();
            searchInput.select();
            if (window.announceToScreenReader) {
                window.announceToScreenReader('Фокус на поле поиска');
            }
        }
    }

    /**
     * Выбрать все задачи
     */
    selectAllTasks() {
        if (window.bulkOps && typeof window.bulkOps.selectAll === 'function') {
            window.bulkOps.selectAll();
        }
    }

    /**
     * Закрыть все модальные окна
     */
    closeModals() {
        // Закрываем модал создания задачи
        if (typeof window.closeCreateTaskModal === 'function') {
            window.closeCreateTaskModal();
        }

        // Закрываем справку по горячим клавишам
        const helpModal = document.getElementById('shortcuts-help-modal');
        if (helpModal && !helpModal.classList.contains('hidden')) {
            helpModal.classList.add('hidden');
        }
    }

    /**
     * Сохранить текущую форму
     */
    saveCurrentForm(e) {
        e.preventDefault();
        
        // Находим активную форму
        const forms = document.querySelectorAll('form');
        for (const form of forms) {
            if (form.offsetParent !== null) { // видима ли форма
                const submitButton = form.querySelector('[type="submit"]');
                if (submitButton) {
                    submitButton.click();
                    if (window.toast) {
                        window.toast.info('Сохранение...');
                    }
                    return;
                }
            }
        }
    }

    /**
     * Показать справку по горячим клавишам
     */
    showShortcutsHelp() {
        const modal = document.getElementById('shortcuts-help-modal');
        if (modal) {
            modal.classList.remove('hidden');
            if (window.announceToScreenReader) {
                window.announceToScreenReader('Открыта справка по горячим клавишам');
            }
        }
    }

    /**
     * Создать модал справки по горячим клавишам
     */
    createShortcutsHelpModal() {
        const modal = document.createElement('div');
        modal.id = 'shortcuts-help-modal';
        modal.className = 'hidden fixed inset-0 z-50 overflow-y-auto';
        modal.innerHTML = `
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center">
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity bg-gray-900 dark:bg-black opacity-75" onclick="document.getElementById('shortcuts-help-modal').classList.add('hidden')"></div>

                <!-- Modal -->
                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                                Горячие клавиши
                            </h3>
                            <button onclick="document.getElementById('shortcuts-help-modal').classList.add('hidden')" 
                                    class="text-white hover:text-gray-200 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="px-6 py-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Основные</h4>
                                
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="text-gray-700 dark:text-gray-300">Новая задача</span>
                                    <kbd class="px-3 py-1.5 text-sm font-semibold bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm">N</kbd>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="text-gray-700 dark:text-gray-300">Поиск</span>
                                    <kbd class="px-3 py-1.5 text-sm font-semibold bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm">F</kbd>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="text-gray-700 dark:text-gray-300">Выбрать все</span>
                                    <kbd class="px-3 py-1.5 text-sm font-semibold bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm">A</kbd>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="text-gray-700 dark:text-gray-300">Закрыть</span>
                                    <kbd class="px-3 py-1.5 text-sm font-semibold bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm">ESC</kbd>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Комбинации</h4>
                                
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="text-gray-700 dark:text-gray-300">Сохранить</span>
                                    <div class="flex gap-1">
                                        <kbd class="px-2 py-1.5 text-sm font-semibold bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm">Ctrl</kbd>
                                        <span class="text-gray-500">+</span>
                                        <kbd class="px-3 py-1.5 text-sm font-semibold bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm">S</kbd>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="text-gray-700 dark:text-gray-300">Быстрый поиск</span>
                                    <div class="flex gap-1">
                                        <kbd class="px-2 py-1.5 text-sm font-semibold bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm">Ctrl</kbd>
                                        <span class="text-gray-500">+</span>
                                        <kbd class="px-3 py-1.5 text-sm font-semibold bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm">K</kbd>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="text-gray-700 dark:text-gray-300">Справка</span>
                                    <kbd class="px-3 py-1.5 text-sm font-semibold bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm">/</kbd>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border border-indigo-200 dark:border-indigo-800">
                            <p class="text-sm text-indigo-800 dark:text-indigo-200 flex items-start gap-2">
                                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <span>
                                    <strong>Совет:</strong> Используйте горячие клавиши для быстрой работы с задачами. 
                                    На Mac используйте Cmd вместо Ctrl.
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 flex justify-end">
                        <button onclick="document.getElementById('shortcuts-help-modal').classList.add('hidden')"
                                class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all font-medium">
                            Понятно
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
    }

    /**
     * Показать подсказки по горячим клавишам в интерфейсе
     */
    showShortcutHints() {
        // Добавляем подсказку к кнопке создания задачи
        const createButton = document.querySelector('[onclick*="openCreateTaskModal"]');
        if (createButton && !createButton.title) {
            createButton.title = 'Создать задачу (N)';
        }

        // Добавляем кнопку вызова справки в навигацию
        const nav = document.querySelector('nav');
        if (nav) {
            const helpButton = document.createElement('button');
            helpButton.className = 'fixed bottom-6 right-6 w-12 h-12 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full shadow-lg hover:shadow-xl transition-all z-40 flex items-center justify-center group';
            helpButton.title = 'Горячие клавиши (/)';
            helpButton.onclick = () => this.showShortcutsHelp();
            helpButton.innerHTML = `
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
                <span class="absolute bottom-full mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                    Горячие клавиши
                </span>
            `;
            document.body.appendChild(helpButton);
        }
    }
}

// Инициализация
if (typeof window !== 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        window.keyboardShortcuts = new KeyboardShortcuts();
    });
}

export default KeyboardShortcuts;
