@props(['task'])

<div id="editTaskModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 dark:bg-black opacity-75"></div>
        </div>

        <!-- Modal container -->
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700">
            <form id="editTaskForm">
                @csrf
                @method('PATCH')
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Редактировать задачу</h3>
                </div>
                <div class="px-6 py-5 space-y-5">
                    <div>
                        <label for="edit-title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Название</label>
                        <input type="text" id="edit-title" name="title" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300 transition text-base shadow-sm">
                    </div>
                    <div>
                        <label for="edit-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Описание</label>
                        <textarea id="edit-description" name="description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300 transition text-base shadow-sm resize-none"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="edit-due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Дата выполнения</label>
                            <input type="date" id="edit-due_date" name="due_date"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300 transition text-base shadow-sm">
                        </div>
                        <div>
                            <label for="edit-priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Приоритет</label>
                            <select id="edit-priority" name="priority"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300 transition text-base shadow-sm">
                                <option value="low">🟢 Низкий</option>
                                <option value="medium">🟡 Средний</option>
                                <option value="high">🔴 Высокий</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" id="edit-completed" name="completed" value="1"
                                class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500 dark:focus:ring-indigo-400">
                            <label for="edit-completed" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Завершено</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="edit-reminders" name="reminders_enabled" value="1"
                                class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500 dark:focus:ring-indigo-400">
                            <label for="edit-reminders" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Напоминания</label>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 flex justify-end gap-3">
                        <button type="button" id="cancelEdit"
                            class="px-5 py-2.5 text-base font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 transition">
                        Отмена
                    </button>
                    <button type="submit"
                            class="px-5 py-2.5 text-base font-medium text-white bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 transition shadow-md hover:shadow-lg">
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>