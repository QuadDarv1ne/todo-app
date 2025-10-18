<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Мои задачи</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Форма добавления -->
                    <form id="task-form" class="mb-6">
                        @csrf
                        <div class="flex gap-2 mb-2">
                            <input
                                type="text"
                                id="title"
                                placeholder="Новая задача..."
                                class="flex-1 border-gray-300 rounded focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Добавить
                            </button>
                        </div>
                        <textarea 
                            id="description"
                            placeholder="Описание задачи (необязательно)..."
                            class="w-full border-gray-300 rounded focus:border-blue-500 focus:ring-blue-500 text-sm"
                            rows="2"
                        ></textarea>
                    </form>

                    <!-- Фильтры -->
                    <div class="mb-4 flex gap-2">
                        <a href="{{ route('tasks.index', ['filter' => 'all']) }}" 
                           class="px-3 py-1 rounded text-sm {{ $filter === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                            Все
                        </a>
                        <a href="{{ route('tasks.index', ['filter' => 'pending']) }}" 
                           class="px-3 py-1 rounded text-sm {{ $filter === 'pending' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                            Активные
                        </a>
                        <a href="{{ route('tasks.index', ['filter' => 'completed']) }}" 
                           class="px-3 py-1 rounded text-sm {{ $filter === 'completed' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                            Завершенные
                        </a>
                    </div>

                    <!-- Список задач -->
                    <ul id="tasks-list" class="space-y-3">
                        @foreach($tasks as $task)
                            <li class="task-item flex flex-col p-3 border rounded hover:bg-gray-50" data-id="{{ $task->id }}">
                                <div class="flex items-center justify-between w-full">
                                    <div class="flex items-center gap-3 flex-1">
                                        <input
                                            type="checkbox"
                                            class="toggle-completed h-5 w-5 text-blue-600 rounded"
                                            {{ $task->completed ? 'checked' : '' }}
                                            data-id="{{ $task->id }}"
                                        >
                                        <span 
                                            class="editable-title cursor-pointer {{ $task->completed ? 'line-through text-gray-500' : 'text-gray-800' }}"
                                            data-id="{{ $task->id }}"
                                        >
                                            {{ $task->title }}
                                        </span>
                                    </div>
                                    <button
                                        class="delete-task text-red-500 hover:text-red-700 ml-2"
                                        data-id="{{ $task->id }}"
                                    >
                                        Удалить
                                    </button>
                                </div>
                                
                                @if($task->description)
                                    <div class="mt-2 text-sm text-gray-600 editable-description cursor-pointer" data-id="{{ $task->id }}">
                                        {{ $task->description }}
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    @if($tasks->isEmpty())
                        <p class="text-gray-500 text-center mt-6">
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
                    @endif

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
                                : 'text-gray-800');
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
                }
            });

            // Удаление задачи
            document.addEventListener('click', async (e) => {
                if (e.target.classList.contains('delete-task')) {
                    if (!confirm('Удалить задачу?')) return;
                    const taskId = e.target.dataset.id;

                    await fetch(`/tasks/${taskId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    e.target.closest('.task-item').remove();
                }
            });

            // Вспомогательная функция
            function addTaskToDOM(task) {
                const li = document.createElement('li');
                li.className = 'task-item flex flex-col p-3 border rounded hover:bg-gray-50';
                li.dataset.id = task.id;
                
                let descriptionHtml = '';
                if (task.description) {
                    descriptionHtml = `<div class="mt-2 text-sm text-gray-600 editable-description cursor-pointer" data-id="${task.id}">
                        ${task.description}
                    </div>`;
                }
                
                li.innerHTML = `
                    <div class="flex items-center justify-between w-full">
                        <div class="flex items-center gap-3 flex-1">
                            <input type="checkbox" class="toggle-completed h-5 w-5 text-blue-600 rounded" data-id="${task.id}" ${task.completed ? 'checked' : ''}>
                            <span class="editable-title cursor-pointer ${task.completed ? 'line-through text-gray-500' : 'text-gray-800'}" data-id="${task.id}">
                                ${task.title}
                            </span>
                        </div>
                        <button class="delete-task text-red-500 hover:text-red-700 ml-2" data-id="${task.id}">Удалить</button>
                    </div>
                    ${descriptionHtml}
                `;
                tasksList.prepend(li);
            }
        });
    </script>
    @endpush
</x-app-layout>