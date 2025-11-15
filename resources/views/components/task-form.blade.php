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
            <div>
                <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Дата выполнения (необязательно)</label>
                <input
                    type="date"
                    id="due_date"
                    min="{{ now()->addDay()->format('Y-m-d') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-base shadow-sm"
                >
            </div>
        </div>
    </form>
</div>