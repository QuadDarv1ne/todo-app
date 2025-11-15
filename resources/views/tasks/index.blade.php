@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with Action Button -->
        <div class="mb-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-100 rounded-lg p-3">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Мои задачи</h1>
                    <p class="mt-1 text-sm text-gray-600">Управляйте своими задачами эффективно</p>
                </div>
            </div>
            <button onclick="openCreateTaskModal()" class="hidden md:inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Создать задачу
            </button>
        </div>

        <!-- Filters with Modern Design -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <form action="{{ route('tasks.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Поиск
                        </label>
                        <input 
                            type="text" 
                            name="search" 
                            id="search" 
                            value="{{ request('search') }}"
                            placeholder="Поиск задач..."
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        >
                    </div>

                    <!-- Filter -->
                    <div>
                        <label for="filter" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Фильтр
                        </label>
                        <select 
                            name="filter" 
                            id="filter"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        >
                            <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Все задачи</option>
                            <option value="active" {{ $filter === 'active' ? 'selected' : '' }}>Активные</option>
                            <option value="completed" {{ $filter === 'completed' ? 'selected' : '' }}>Завершённые</option>
                            <option value="today" {{ $filter === 'today' ? 'selected' : '' }}>На сегодня</option>
                            <option value="week" {{ $filter === 'week' ? 'selected' : '' }}>На неделю</option>
                            <option value="overdue" {{ $filter === 'overdue' ? 'selected' : '' }}>Просроченные</option>
                        </select>
                    </div>

                    <!-- Priority -->
                    <div>
                        <label for="priority" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            Приоритет
                        </label>
                        <select 
                            name="priority" 
                            id="priority"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        >
                            <option value="">Все</option>
                            <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>Высокий</option>
                            <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Средний</option>
                            <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Низкий</option>
                        </select>
                    </div>

                    <!-- Tag -->
                    @if($userTags && $userTags->isNotEmpty())
                    <div>
                        <label for="tag" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Тег
                        </label>
                        <select 
                            name="tag" 
                            id="tag"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        >
                            <option value="">Все теги</option>
                            @foreach($userTags as $tag)
                                <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Применить фильтры
                    </button>
                    <a href="{{ route('tasks.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Сбросить
                    </a>
                </div>
            </form>
        </div>

        <!-- Tasks List -->
        @if($tasks->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-16 text-center">
                <div class="bg-gray-100 rounded-full w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Задачи не найдены</h3>
                <p class="text-gray-600 mb-6">Создайте свою первую задачу или измените фильтры</p>
                <button onclick="openCreateTaskModal()" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Создать первую задачу
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 gap-4">
                @foreach($tasks as $task)
                    <div class="task-card group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-200 overflow-hidden {{ $task->completed ? 'opacity-75' : '' }}">
                        <!-- Priority Bar -->
                        <div class="h-1.5 {{ $task->priority === 'high' ? 'bg-red-500' : ($task->priority === 'medium' ? 'bg-yellow-500' : 'bg-green-500') }}"></div>
                        
                        <div class="p-6">
                            <div class="flex items-start gap-4">
                                <!-- Checkbox -->
                                <div class="flex-shrink-0 mt-1">
                                    <input 
                                        type="checkbox" 
                                        class="task-toggle w-6 h-6 text-indigo-600 rounded-lg border-2 border-gray-300 focus:ring-2 focus:ring-indigo-500 cursor-pointer transition-all"
                                        data-id="{{ $task->id }}"
                                        {{ $task->completed ? 'checked' : '' }}
                                    >
                                </div>

                                <!-- Task Content -->
                                <div class="flex-grow">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-grow">
                                            <h3 class="task-title text-lg font-bold {{ $task->completed ? 'line-through text-gray-400' : 'text-gray-900' }} mb-2">
                                                {{ $task->title }}
                                            </h3>
                                            
                                            @if($task->description)
                                                <p class="text-sm text-gray-600 leading-relaxed">{{ $task->description }}</p>
                                            @endif

                                            <!-- Meta info -->
                                            <div class="mt-4 flex flex-wrap gap-2 text-sm">
                                                <!-- Priority -->
                                                @if($task->priority)
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold shadow-sm
                                                        {{ $task->priority === 'high' ? 'bg-gradient-to-r from-red-500 to-red-600 text-white' : '' }}
                                                        {{ $task->priority === 'medium' ? 'bg-gradient-to-r from-yellow-400 to-yellow-500 text-white' : '' }}
                                                        {{ $task->priority === 'low' ? 'bg-gradient-to-r from-green-500 to-green-600 text-white' : '' }}
                                                    ">
                                                        @if($task->priority === 'high')
                                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                                                            </svg>
                                                            Высокий
                                                        @elseif($task->priority === 'medium')
                                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                                            </svg>
                                                            Средний
                                                        @else
                                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM9 9V7a1 1 0 112 0v2.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414L9 9.586z" clip-rule="evenodd" />
                                                            </svg>
                                                            Низкий
                                                        @endif
                                                    </span>
                                                @endif

                                                <!-- Due date -->
                                                @if($task->due_date)
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                                        </svg>
                                                        {{ \Carbon\Carbon::parse($task->due_date)->format('d.m.Y') }}
                                                    </span>
                                                @endif

                                                <!-- Status -->
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold
                                                    {{ $task->completed ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-indigo-50 text-indigo-700 border border-indigo-200' }}
                                                ">
                                                    @if($task->completed)
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        Завершено
                                                    @else
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                    </svg>
                                                    Активно
                                                @endif
                                            </span>

                                                <!-- Tags -->
                                                @if($task->tags && $task->tags->isNotEmpty())
                                                    @foreach($task->tags as $tag)
                                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                                            </svg>
                                                            {{ $tag->name }}
                                                        </span>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex-shrink-0 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button 
                                                class="edit-task p-2.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-all hover:scale-110"
                                                data-id="{{ $task->id }}"
                                                title="Редактировать"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>

                                            <button 
                                                class="delete-task p-2.5 text-red-600 hover:bg-red-50 rounded-lg transition-all hover:scale-110"
                                                data-id="{{ $task->id }}"
                                                title="Удалить"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Create Task Modal -->
<div id="createTaskModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="closeCreateTaskModal()">
            <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
        </div>

        <!-- Modal container -->
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <form action="{{ route('tasks.store') }}" method="POST" id="createTaskForm">
                @csrf
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-5">
                    <h3 class="text-2xl font-bold text-white">Создать новую задачу</h3>
                </div>
                <div class="px-6 py-6 space-y-5">
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Название задачи *</label>
                        <input type="text" id="title" name="title" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-base shadow-sm"
                               placeholder="Введите название задачи">
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Описание</label>
                        <textarea id="description" name="description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-base shadow-sm resize-none"
                                  placeholder="Опишите детали задачи..."></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="due_date" class="block text-sm font-semibold text-gray-700 mb-2">Дата выполнения</label>
                            <input type="date" id="due_date" name="due_date"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-base shadow-sm">
                        </div>
                        <div>
                            <label for="priority" class="block text-sm font-semibold text-gray-700 mb-2">Приоритет</label>
                            <select id="priority" name="priority"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-base shadow-sm">
                                <option value="low">Низкий</option>
                                <option value="medium" selected>Средний</option>
                                <option value="high">Высокий</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" id="reminders_enabled" name="reminders_enabled" value="1"
                                   class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500">
                            <span class="ml-3 text-sm font-medium text-gray-700">Включить напоминания</span>
                        </label>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">
                    <button type="button" onclick="closeCreateTaskModal()"
                            class="px-6 py-2.5 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Отмена
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-md hover:shadow-lg">
                        Создать задачу
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<x-edit-task-modal />

@section('scripts')
<script>
function openCreateTaskModal() {
    document.getElementById('createTaskModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCreateTaskModal() {
    document.getElementById('createTaskModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('createTaskForm').reset();
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCreateTaskModal();
        closeEditTaskModal();
    }
});

// Edit Task functionality
document.querySelectorAll('.edit-task').forEach(button => {
    button.addEventListener('click', async function() {
        const taskId = this.dataset.id;
        
        try {
            const response = await fetch(`/tasks/${taskId}`);
            const data = await response.json();
            
            if (data.success) {
                const task = data.task;
                document.getElementById('edit-title').value = task.title || '';
                document.getElementById('edit-description').value = task.description || '';
                document.getElementById('edit-due_date').value = task.due_date || '';
                document.getElementById('edit-priority').value = task.priority || 'medium';
                document.getElementById('edit-completed').checked = task.completed || false;
                document.getElementById('edit-reminders').checked = task.reminders_enabled || false;
                document.getElementById('editTaskForm').dataset.taskId = taskId;
                
                document.getElementById('editTaskModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        } catch (error) {
            console.error('Error loading task:', error);
            alert('Ошибка при загрузке задачи');
        }
    });
});

function closeEditTaskModal() {
    document.getElementById('editTaskModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

document.getElementById('cancelEdit')?.addEventListener('click', closeEditTaskModal);

// Save edited task
document.getElementById('editTaskForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const taskId = this.dataset.taskId;
    const formData = new FormData(this);
    
    try {
        const response = await fetch(`/tasks/${taskId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message || 'Ошибка при сохранении задачи');
        }
    } catch (error) {
        console.error('Error updating task:', error);
        alert('Ошибка при сохранении задачи');
    }
});

// Delete Task functionality
document.querySelectorAll('.delete-task').forEach(button => {
    button.addEventListener('click', async function() {
        if (!confirm('Вы уверены, что хотите удалить эту задачу?')) {
            return;
        }
        
        const taskId = this.dataset.id;
        
        try {
            const response = await fetch(`/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Ошибка при удалении задачи');
            }
        } catch (error) {
            console.error('Error deleting task:', error);
            alert('Ошибка при удалении задачи');
        }
    });
});

// Toggle task completion
document.querySelectorAll('.task-toggle').forEach(checkbox => {
    checkbox.addEventListener('change', async function() {
        const taskId = this.dataset.id;
        const completed = this.checked;
        
        try {
            const response = await fetch(`/tasks/${taskId}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ completed })
            });
            
            const data = await response.json();
            
            if (data.success) {
                window.location.reload();
            } else {
                this.checked = !completed;
                alert(data.message || 'Ошибка при обновлении задачи');
            }
        } catch (error) {
            console.error('Error toggling task:', error);
            this.checked = !completed;
            alert('Ошибка при обновлении задачи');
        }
    });
});
</script>
@endsection
@endsection