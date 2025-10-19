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
            <div class="mb-8 bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-semibold text-gray-900">Прогресс выполнения</h3>
                    <span class="text-2xl font-bold text-indigo-600">{{ $progressPercentage }}%</span>
                </div>
                <div class="h-3 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-indigo-600 to-purple-600 transition-all duration-500 rounded-full" style="width: <?php echo $progressPercentage; ?>%"></div>
                </div>
                <div class="mt-2 text-xs text-gray-500">{{ $completedTasks }} из {{ $totalTasks }} задач выполнено</div>
            </div>
        @endif

        <!-- Add Task Form -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <form id="task-form" class="space-y-4">
                @csrf
                <div class="flex gap-2">
                    <input
                        type="text"
                        id="title"
                        placeholder="Введите название задачи..."
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-sm"
                        required
                    >
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-sm">
                        Добавить
                    </button>
                </div>
                <textarea 
                    id="description"
                    placeholder="Описание задачи (необязательно)..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-sm resize-none"
                    rows="2"
                ></textarea>
            </form>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <form method="GET" action="{{ route('tasks.index') }}" class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Поиск задач..."
                            class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-sm"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        @if(request('search'))
                            <a href="{{ route('tasks.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        @endif
                    </form>
                </div>
                
                <!-- Filters -->
                <div class="flex flex-wrap gap-2">
                    @php
                        $filters = [
                            'all' => 'Все задачи',
                            'pending' => 'Активные',
                            'completed' => 'Завершённые'
                        ];
                    @endphp
                    
                    @foreach($filters as $key => $label)
                        <a href="{{ route('tasks.index', array_merge(request()->except('filter', 'page'), ['filter' => $key])) }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $filter === $key ? 'bg-indigo-600 text-white shadow-md' : 'bg-white text-gray-700 border border-gray-200 hover:border-gray-300' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Tasks List -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            @forelse($tasks as $task)
                <div class="task-item border-b last:border-b-0 hover:bg-gray-50 transition p-4 sm:p-6 flex items-start justify-between gap-4" data-id="{{ $task->id }}">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start gap-3">
                            <input
                                type="checkbox"
                                class="toggle-completed mt-1 h-5 w-5 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500 cursor-pointer flex-shrink-0"
                                {{ $task->completed ? 'checked' : '' }}
                                data-id="{{ $task->id }}"
                            >
                            <div class="flex-1 min-w-0">
                                <p class="editable-title cursor-pointer text-base font-medium {{ $task->completed ? 'line-through text-gray-400' : 'text-gray-900' }} break-words" data-id="{{ $task->id }}">
                                    {{ $task->title }}
                                </p>
                                
                                @if($task->description)
                                    <p class="editable-description cursor-pointer text-sm text-gray-600 mt-1 break-words" data-id="{{ $task->id }}">
                                        {{ $task->description }}
                                    </p>
                                @endif
                                
                                <div class="flex items-center gap-2 mt-2 text-xs text-gray-500">
                                    <span class="px-2 py-1 rounded-full {{ $task->completed ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $task->completed ? 'Завершено' : 'Активно' }}
                                    </span>
                                    <span>{{ $task->created_at->format('d.m.Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button
                        class="delete-task text-gray-400 hover:text-red-600 transition flex-shrink-0 p-2"
                        data-id="{{ $task->id }}"
                        title="Удалить задачу"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @empty
                <div class="p-12 text-center">
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
    const tasksList = document.querySelector('.bg-white.rounded-lg.shadow-sm.overflow-hidden') || document.body;

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
        if (e.target.classList.contains('toggle-completed')) {
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
});
</script>
@endpush

@endsection