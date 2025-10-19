<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Мои задачи</h2>
            <div class="text-sm text-gray-500">
                Всего: {{ auth()->user()->tasks()->count() }} | 
                Активные: {{ auth()->user()->tasks()->where('completed', false)->count() }} | 
                Завершенные: {{ auth()->user()->tasks()->where('completed', true)->count() }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Форма добавления -->
                    <form id="task-form" class="mb-6 bg-gray-50 p-4 rounded-lg">
                        @csrf
                        <div class="flex gap-2 mb-2">
                            <input
                                type="text"
                                id="title"
                                placeholder="Новая задача..."
                                class="flex-1 border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                required
                            >
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200 shadow-sm">
                                Добавить
                            </button>
                        </div>
                        <textarea 
                            id="description"
                            placeholder="Описание задачи (необязательно)..."
                            class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm"
                            rows="2"
                        ></textarea>
                    </form>

                    <!-- Фильтры -->
                    <div class="mb-4 flex gap-2">
                        <a href="{{ route('tasks.index', ['filter' => 'all']) }}" 
                           class="px-4 py-2 rounded-lg text-sm {{ $filter === 'all' ? 'bg-indigo-600 text-white shadow' : 'bg-gray-200 hover:bg-gray-300' }}">
                            Все
                        </a>
                        <a href="{{ route('tasks.index', ['filter' => 'pending']) }}" 
                           class="px-4 py-2 rounded-lg text-sm {{ $filter === 'pending' ? 'bg-indigo-600 text-white shadow' : 'bg-gray-200 hover:bg-gray-300' }}">
                            Активные
                        </a>
                        <a href="{{ route('tasks.index', ['filter' => 'completed']) }}" 
                           class="px-4 py-2 rounded-lg text-sm {{ $filter === 'completed' ? 'bg-indigo-600 text-white shadow' : 'bg-gray-200 hover:bg-gray-300' }}">
                            Завершенные
                        </a>
                    </div>

                    <!-- Статистика -->
                    <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                        <div class="flex justify-between text-sm">
                            <span>Прогресс выполнения:</span>
                            @php
                                $totalTasks = auth()->user()->tasks()->count();
                                $completedTasks = auth()->user()->tasks()->where('completed', true)->count();
                                $progressPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                            @endphp
                            <span class="font-medium">{{ $progressPercentage }}%</span>
                        </div>
                        <div class="mt-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-600 rounded-full" style="width: <?php echo $progressPercentage; ?>%"></div>
                        </div>
                    </div>

                    <!-- Список задач -->
                    <ul id="tasks-list" class="space-y-3">
                        @forelse($tasks as $task)
                            <li class="task-item flex flex-col p-4 border rounded-lg hover:bg-gray-50 transition duration-150 shadow-sm" data-id="{{ $task->id }}">
                                <div class="flex items-center justify-between w-full">
                                    <div class="flex items-center gap-3 flex-1">
                                        <input
                                            type="checkbox"
                                            class="toggle-completed h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500"
                                            {{ $task->completed ? 'checked' : '' }}
                                            data-id="{{ $task->id }}"
                                        >
                                        <span 
                                            class="editable-title cursor-pointer {{ $task->completed ? 'line-through text-gray-500' : 'text-gray-800 font-medium' }}"
                                            data-id="{{ $task->id }}"
                                        >
                                            {{ $task->title }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if(!$task->completed)
                                            <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">Активно</span>
                                        @else
                                            <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">Завершено</span>
                                        @endif
                                        <button
                                            class="delete-task text-red-500 hover:text-red-700 ml-2"
                                            data-id="{{ $task->id }}"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                
                                @if($task->description)
                                    <div class="mt-2 text-sm text-gray-600 editable-description cursor-pointer" data-id="{{ $task->id }}">
                                        {{ $task->description }}
                                    </div>
                                @endif
                                
                                <div class="mt-2 text-xs text-gray-400">
                                    Создано: {{ $task->created_at->format('d.m.Y H:i') }}
                                    @if($task->completed)
                                        | Завершено: {{ $task->updated_at->format('d.m.Y H:i') }}
                                    @endif
                                </div>
                            </li>
                        @empty
                            <li class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Нет задач</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    @switch($filter)
                                        @case('pending')
                                            Нет активных задач. Добавьте новую задачу!
                                            @break
                                        @case('completed')
                                            Нет завершенных задач.
                                            @break
                                        @default
                                            Список пуст. Добавьте первую задачу!
                                    @endswitch
                                </p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('task-form');
            const tasksList = document.getElementById('tasks-list');

            // Инициализация Sortable
            if (tasksList) {
                new Sortable(tasksList, {
                    animation: 150,
                    handle: '.editable-title', // перетаскиваем только за текст
                    onEnd: async function (evt) {
                        const newOrder = [];
                        tasksList.querySelectorAll('.task-item').forEach((el, index) => {
                            newOrder.push({
                                id: el.dataset.id,
                                order: index
                            });
                        });

                        await fetch('{{ route("tasks.reorder") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ tasks: newOrder })
                        });
                    }
                });
            }

            // Добавление задачи
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const title = document.getElementById('title').value.trim();
                const description = document.getElementById('description').value.trim();
                
                if (!title) return;

                const res = await fetch('{{ route("tasks.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        title,
                        description: description || null
                    })
                });

                const data = await res.json();
                if (data.success) {
                    form.reset();
                    addTaskToDOM(data.task);
                    // Обновляем статистику
                    location.reload();
                }
            });

            // Редактирование заголовка по двойному клику
            document.addEventListener('dblclick', async (e) => {
                if (e.target.classList.contains('editable-title')) {
                    const taskId = e.target.dataset.id;
                    const currentTitle = e.target.textContent;
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.value = currentTitle;
                    input.className = 'border rounded px-1 py-0.5 w-3/4';
                    input.autofocus = true;

                    e.target.replaceWith(input);

                    const saveEdit = async () => {
                        const newTitle = input.value.trim();
                        if (newTitle && newTitle !== currentTitle) {
                            await fetch(`/tasks/${taskId}`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({ title: newTitle })
                            });
                            e.target.textContent = newTitle;
                        }
                        // Вернуть span
                        const span = document.createElement('span');
                        span.className = 'editable-title cursor-pointer ' + 
                            (document.querySelector(`.task-item[data-id="${taskId}"] .toggle-completed`).checked 
                                ? 'line-through text-gray-500' 
                                : 'text-gray-800 font-medium');
                        span.dataset.id = taskId;
                        span.textContent = input.value.trim() || currentTitle;
                        input.replaceWith(span);
                    };

                    input.addEventListener('blur', saveEdit);
                    input.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter') saveEdit();
                    });
                }
            });

            // Редактирование описания по двойному клику
            document.addEventListener('dblclick', async (e) => {
                if (e.target.classList.contains('editable-description')) {
                    const taskId = e.target.dataset.id;
                    const currentDescription = e.target.textContent;
                    const textarea = document.createElement('textarea');
                    textarea.value = currentDescription;
                    textarea.className = 'border rounded px-1 py-0.5 w-full mt-1';
                    textarea.rows = 3;
                    textarea.autofocus = true;

                    e.target.replaceWith(textarea);

                    const saveEdit = async () => {
                        const newDescription = textarea.value.trim();
                        // Проверяем, изменилось ли описание
                        if (newDescription !== currentDescription) {
                            await fetch(`/tasks/${taskId}`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({ description: newDescription || null })
                            });
                            
                            // Обновляем DOM
                            if (newDescription) {
                                e.target.textContent = newDescription;
                            } else {
                                // Если описание пустое, удаляем элемент
                                textarea.remove();
                                return;
                            }
                        }
                        
                        // Вернуть div
                        const div = document.createElement('div');
                        div.className = 'mt-2 text-sm text-gray-600 editable-description cursor-pointer';
                        div.dataset.id = taskId;
                        div.textContent = textarea.value.trim();
                        textarea.replaceWith(div);
                    };

                    textarea.addEventListener('blur', saveEdit);
                    textarea.addEventListener('keypress', (e) => {
                        // Ctrl+Enter для сохранения
                        if (e.key === 'Enter' && e.ctrlKey) saveEdit();
                    });
                }
            });

            // Переключение статуса
            document.addEventListener('change', async (e) => {
                if (e.target.classList.contains('toggle-completed')) {
                    const taskId = e.target.dataset.id;
                    const completed = e.target.checked;

                    await fetch(`/tasks/${taskId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ completed })
                    });

                    // Обновляем стиль текста
                    const titleEl = document.querySelector(`.editable-title[data-id="${taskId}"]`);
                    titleEl.classList.toggle('line-through', completed);
                    titleEl.classList.toggle('text-gray-500', completed);
                    titleEl.classList.toggle('text-gray-800', !completed);
                    titleEl.classList.toggle('font-medium', !completed);

                    // Обновляем статусный бейдж
                    const taskItem = e.target.closest('.task-item');
                    const badge = taskItem.querySelector('span.rounded-full');
                    if (badge) {
                        if (completed) {
                            badge.className = 'text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full';
                            badge.textContent = 'Завершено';
                        } else {
                            badge.className = 'text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full';
                            badge.textContent = 'Активно';
                        }
                    }

                    // Обновляем статистику
                    location.reload();
                }
            });

            // Удаление задачи
            document.addEventListener('click', async (e) => {
                if (e.target.classList.contains('delete-task') || e.target.closest('.delete-task')) {
                    const deleteButton = e.target.closest('.delete-task');
                    if (!confirm('Удалить задачу?')) return;
                    const taskId = deleteButton.dataset.id;

                    await fetch(`/tasks/${taskId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    deleteButton.closest('.task-item').remove();
                    // Обновляем статистику
                    location.reload();
                }
            });

            // Вспомогательная функция
            function addTaskToDOM(task) {
                const li = document.createElement('li');
                li.className = 'task-item flex flex-col p-4 border rounded-lg hover:bg-gray-50 transition duration-150 shadow-sm';
                li.dataset.id = task.id;
                
                let descriptionHtml = '';
                if (task.description) {
                    descriptionHtml = `<div class="mt-2 text-sm text-gray-600 editable-description cursor-pointer" data-id="${task.id}">
                        ${task.description}
                    </div>`;
                }
                
                let badgeHtml = task.completed 
                    ? '<span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">Завершено</span>' 
                    : '<span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">Активно</span>';
                
                let createdAt = new Date(task.created_at).toLocaleString('ru-RU', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                let updatedAtHtml = task.completed 
                    ? ` | Завершено: ${new Date(task.updated_at).toLocaleString('ru-RU', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    })}` 
                    : '';
                
                li.innerHTML = `
                    <div class="flex items-center justify-between w-full">
                        <div class="flex items-center gap-3 flex-1">
                            <input type="checkbox" class="toggle-completed h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500" data-id="${task.id}" ${task.completed ? 'checked' : ''}>
                            <span class="editable-title cursor-pointer ${task.completed ? 'line-through text-gray-500' : 'text-gray-800 font-medium'}" data-id="${task.id}">
                                ${task.title}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            ${badgeHtml}
                            <button class="delete-task text-red-500 hover:text-red-700 ml-2" data-id="${task.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    ${descriptionHtml}
                    <div class="mt-2 text-xs text-gray-400">
                        Создано: ${createdAt}${updatedAtHtml}
                    </div>
                `;
                tasksList.prepend(li);
            }
        });
    </script>
    @endpush
</x-app-layout>