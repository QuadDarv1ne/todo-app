@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Мои задачи
    </h2>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 shadow-sm sticky top-16 z-40">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Мои задачи</h1>
                <div class="grid grid-cols-3 gap-4 text-sm">
                    <div class="text-center">
                        <div class="text-lg font-semibold text-gray-900">{{ auth()->user()->tasks()->count() }}</div>
                        <div class="text-gray-500">Всего</div>
                    </div>
                    <div class="text-center">
                        <div class="text-lg font-semibold text-blue-600">{{ auth()->user()->tasks()->where('completed', false)->count() }}</div>
                        <div class="text-gray-500">Активные</div>
                    </div>
                    <div class="text-center">
                        <div class="text-lg font-semibold text-green-600">{{ auth()->user()->tasks()->where('completed', true)->count() }}</div>
                        <div class="text-gray-500">Завершены</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Progress Bar -->
        @php
            $totalTasks = auth()->user()->tasks()->count();
            $completedTasks = auth()->user()->tasks()->where('completed', true)->count();
            $progressPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        @endphp
        
        @if($totalTasks > 0)
            <div class="mb-8">
                <x-progress-bar 
                    :percentage="$progressPercentage"
                    label="Прогресс выполнения"
                >
                    {{ $completedTasks }} из {{ $totalTasks }} задач выполнено
                </x-progress-bar>
            </div>
        @endif

        <!-- Add Task Form -->
        <x-task-form class="mb-8" />

        <!-- Search and Filters -->
        <x-task-filters :current-filter="$filter" :search-query="request('search')" class="mb-8" />

        <!-- Tasks List -->
        <div class="space-y-3">
            @forelse($tasks as $task)
                <x-task-card :task="$task" />
            @empty
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Нет задач</h3>
                    <p class="mt-2 text-gray-600">
                        @switch($filter)
                            @case('pending')
                                Все задачи выполнены! 🎉
                            @break
                            @case('completed')
                                Ещё нет завершённых задач.
                            @break
                            @default
                                @if(request('search'))
                                    По вашему запросу "{{ request('search') }}" ничего не найдено.
                                @else
                                    Начните с создания первой задачи!
                                @endif
                        @endswitch
                    </p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($tasks->hasPages())
            <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
                {{ $tasks->appends(request()->except('page'))->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('task-form');
    
    // Добавление задачи
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        
        if (!title) return;

        try {
            const res = await fetch('{{ route("tasks.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ title, description: description || null })
            });

            if (res.ok) {
                const data = await res.json();
                form.reset();
                window.location.reload();
            } else {
                const error = await res.json();
                alert(error.message || 'Не удалось добавить задачу');
            }
        } catch (error) {
            console.error('Ошибка:', error);
            alert('Не удалось добавить задачу');
        }
    });

    // Редактирование по двойному клику
    document.addEventListener('dblclick', async (e) => {
        if (e.target.classList.contains('editable-title') || e.target.classList.contains('editable-description')) {
            const isTitle = e.target.classList.contains('editable-title');
            const taskId = e.target.dataset.id;
            const currentValue = e.target.textContent.trim();
            
            const input = isTitle 
                ? document.createElement('input')
                : document.createElement('textarea');
            
            input.type = isTitle ? 'text' : 'text';
            input.value = currentValue;
            input.className = 'px-2 py-1 border border-indigo-400 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full';
            if (!isTitle) input.rows = 3;
            input.autofocus = true;

            e.target.replaceWith(input);

            const saveEdit = async () => {
                const newValue = input.value.trim();
                if (newValue && newValue !== currentValue) {
                    try {
                        const res = await fetch(`/tasks/${taskId}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ [isTitle ? 'title' : 'description']: newValue })
                        });
                        
                        if (!res.ok) {
                            const error = await res.json();
                            throw new Error(error.message || 'Ошибка при сохранении');
                        }
                        
                        window.location.reload();
                    } catch (error) {
                        console.error('Ошибка при сохранении:', error);
                        alert(error.message || 'Ошибка при сохранении изменений');
                        restoreElement(isTitle, taskId, currentValue);
                    }
                } else {
                    restoreElement(isTitle, taskId, currentValue);
                }
            };

            const restoreElement = (isTitle, taskId, value) => {
                const element = isTitle 
                    ? document.createElement('p')
                    : document.createElement('p');
                
                element.className = isTitle 
                    ? 'editable-title cursor-pointer text-base font-medium break-words'
                    : 'editable-description cursor-pointer text-sm text-gray-600 mt-1 break-words';
                element.dataset.id = taskId;
                element.textContent = value;
                input.replaceWith(element);
            };

            input.addEventListener('blur', saveEdit);
            input.addEventListener('keypress', (e) => {
                if (isTitle && e.key === 'Enter') saveEdit();
                if (!isTitle && e.key === 'Enter' && e.ctrlKey) saveEdit();
            });
        }
    });

    // Переключение статуса
    document.addEventListener('change', async (e) => {
        if (e.target.classList.contains('task-toggle')) {
            const taskId = e.target.dataset.id;
            const completed = e.target.checked;

            try {
                const res = await fetch(`/tasks/${taskId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ completed })
                });
                
                if (!res.ok) {
                    const error = await res.json();
                    throw new Error(error.message || 'Ошибка при обновлении статуса');
                }
                
                window.location.reload();
            } catch (error) {
                console.error('Ошибка:', error);
                alert(error.message || 'Ошибка при обновлении статуса задачи');
                // Восстановить предыдущее состояние
                e.target.checked = !completed;
            }
        }
    });

    // Удаление задачи
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.delete-task');
        if (!btn) return;
        
        if (!confirm('Удалить задачу?')) return;
        
        const taskId = btn.dataset.id;

        try {
            const res = await fetch(`/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            if (!res.ok) {
                const error = await res.json();
                throw new Error(error.message || 'Ошибка при удалении задачи');
            }
            
            window.location.reload();
        } catch (error) {
            console.error('Ошибка при удалении:', error);
            alert(error.message || 'Ошибка при удалении задачи');
        }
    });
    
    // Редактирование задачи
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.edit-task');
        if (!btn) return;
        
        const taskId = btn.dataset.id;
        // Здесь можно добавить логику для открытия модального окна редактирования
        console.log('Edit task:', taskId);
    });
});
</script>
@endpush

@endsection