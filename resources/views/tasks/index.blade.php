<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Мои задачи</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Форма добавления -->
                    <form id="task-form" class="mb-6 flex gap-2">
                        @csrf
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
                    </form>

                    <!-- Список задач -->
                    <ul id="tasks-list" class="space-y-3">
                        @foreach($tasks as $task)
                            <li class="task-item flex items-center justify-between p-3 border rounded hover:bg-gray-50" data-id="{{ $task->id }}">
                                <div class="flex items-center gap-3">
                                    <input
                                        type="checkbox"
                                        class="toggle-completed h-5 w-5 text-blue-600 rounded"
                                        {{ $task->completed ? 'checked' : '' }}
                                        data-id="{{ $task->id }}"
                                    >
                                    <span class="{{ $task->completed ? 'line-through text-gray-500' : 'text-gray-800' }}">
                                        {{ $task->title }}
                                    </span>
                                </div>
                                <button
                                    class="delete-task text-red-500 hover:text-red-700"
                                    data-id="{{ $task->id }}"
                                >
                                    Удалить
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    @if($tasks->isEmpty())
                        <p class="text-gray-500 text-center mt-6">Список пуст. Добавьте первую задачу!</p>
                    @endif

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('task-form');
            const tasksList = document.getElementById('tasks-list');

            // Добавление задачи
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const title = document.getElementById('title').value.trim();
                if (!title) return;

                const res = await fetch('{{ route("tasks.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ title })
                });

                const data = await res.json();
                if (data.success) {
                    form.reset();
                    addTaskToDOM(data.task);
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

                    // Обновляем стиль
                    const taskText = e.target.closest('.task-item').querySelector('span');
                    taskText.classList.toggle('line-through', completed);
                    taskText.classList.toggle('text-gray-500', completed);
                    taskText.classList.toggle('text-gray-800', !completed);
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
                li.className = 'task-item flex items-center justify-between p-3 border rounded hover:bg-gray-50';
                li.dataset.id = task.id;
                li.innerHTML = `
                    <div class="flex items-center gap-3">
                        <input type="checkbox" class="toggle-completed h-5 w-5 text-blue-600 rounded" data-id="${task.id}">
                        <span class="text-gray-800">${task.title}</span>
                    </div>
                    <button class="delete-task text-red-500 hover:text-red-700" data-id="${task.id}">Удалить</button>
                `;
                tasksList.prepend(li);
            }
        });
    </script>
    @endpush
</x-app-layout>