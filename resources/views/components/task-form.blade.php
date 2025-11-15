<div class="task-form bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <form id="task-form" class="space-y-5">
        @csrf
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input
                    type="text"
                    id="title"
                    placeholder="Введите название задачи..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-base shadow-sm"
                    required
                >
            </div>
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Добавить
                </span>
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <textarea 
                id="description"
                placeholder="Описание задачи (необязательно)..."
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-base resize-none shadow-sm"
                rows="3"
            ></textarea>
            <div class="grid grid-cols-1 gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Дата выполнения</label>
                        <input
                            type="date"
                            id="due_date"
                            min="{{ now()->addDay()->format('Y-m-d') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-base shadow-sm"
                        >
                    </div>
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Приоритет</label>
                        <select 
                            id="priority"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-base shadow-sm"
                        >
                            <option value="low">🟢 Низкий</option>
                            <option value="medium" selected>🟡 Средний</option>
                            <option value="high">🔴 Высокий</option>
                        </select>
                    </div>
                </div>
                
                <!-- Reminder Toggle -->
                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                    <div>
                        <h4 class="text-md font-medium text-gray-900">Напоминания</h4>
                        <p class="text-sm text-gray-500">Получать уведомления о приближающемся сроке</p>
                    </div>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none">
                        <input type="checkbox" name="enable_reminders" id="enable-reminders" 
                               class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-all duration-200 ease-in-out"
                               checked>
                        <label for="enable-reminders" 
                               class="toggle-label block overflow-hidden h-6 rounded-full bg-indigo-600 cursor-pointer transition-all duration-200 ease-in-out"></label>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>