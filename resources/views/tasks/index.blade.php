@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        Мои задачи
    </h2>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 shadow-sm sticky top-16 z-40">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 sm:gap-5">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Мои задачи</h1>
                <div class="grid grid-cols-3 gap-3 sm:gap-5 text-sm sm:text-base">
                    <div class="text-center">
                        <div class="text-xl sm:text-2xl font-bold text-gray-900">{{ auth()->user()->tasks()->count() }}</div>
                        <div class="text-gray-500 text-xs sm:text-sm">Всего</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl sm:text-2xl font-bold text-blue-600">{{ auth()->user()->tasks()->where('completed', false)->count() }}</div>
                        <div class="text-gray-500 text-xs sm:text-sm">Активные</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl sm:text-2xl font-bold text-green-600">{{ auth()->user()->tasks()->where('completed', true)->count() }}</div>
                        <div class="text-gray-500 text-xs sm:text-sm">Завершены</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Progress Bar -->
        @php
            $totalTasks = auth()->user()->tasks()->count();
            $completedTasks = auth()->user()->tasks()->where('completed', true)->count();
            $progressPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        @endphp
        
        @if($totalTasks > 0)
            <div class="mb-10">
                <x-progress-bar 
                    :percentage="$progressPercentage"
                    label="Прогресс выполнения"
                >
                    {{ $completedTasks }} из {{ $totalTasks }} задач выполнено
                </x-progress-bar>
            </div>
        @endif

        <!-- Add Task Form -->
        <x-task-form class="mb-10" />

        <!-- Search and Filters -->
        <x-task-filters :current-filter="$filter" :search-query="request('search')" :user-tags="$userTags" class="mb-10" />

        <!-- Tasks List -->
        @if($tasks->count() > 0)
            @if($filter === 'all')
                <!-- Use drag and drop for all tasks view -->
                <x-drag-drop-task-list :tasks="$tasks" />
            @else
                <!-- Use regular list for filtered views -->
                <div class="space-y-5">
                    @foreach($tasks as $task)
                        <x-task-card :task="$task" />
                    @endforeach
                </div>
            @endif
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                @switch($filter)
                    @case('pending')
                        <x-empty-state
                            title="Все задачи выполнены!"
                            description="🎉 Поздравляем! У вас нет активных задач."
                            icon='<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>'
                        />
                    @break
                    @case('completed')
                        <x-empty-state
                            title="Нет завершённых задач"
                            description="У вас ещё нет завершённых задач. Продолжайте работать!"
                            icon='<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>'
                        />
                    @break
                    @default
                        @if(request('search'))
                            <x-empty-state
                                title="Ничего не найдено"
                                description='По вашему запросу "{{ request('search') }}" ничего не найдено.'
                                icon='<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>'
                            />
                        @else
                            <x-empty-state
                                title="Нет задач"
                                description="Начните с создания своей первой задачи!"
                                icon='<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>'
                                action-text="Создать задачу"
                                action-url="{{ route('tasks.index') }}#task-form"
                            />
                        @endif
                @endswitch
            </div>
        @endif
        
        <!-- Pagination -->
        @if($tasks->hasPages())
            <div class="mt-12 bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex justify-center">
                    {{ $tasks->appends(request()->except('page'))->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Edit Task Modal -->
<x-edit-task-modal />

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('task-form');
    
    // Add task
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        const dueDate = document.getElementById('due_date').value;
        const priority = document.getElementById('priority').value;
        
        if (!title) return;

        try {
            const res = await fetch('{{ route("tasks.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ 
                    title, 
                    description: description || null,
                    due_date: dueDate || null,
                    priority: priority
                })
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

    // Edit task modal
    const editModal = document.getElementById('editTaskModal');
    const editForm = document.getElementById('editTaskForm');
    const cancelEdit = document.getElementById('cancelEdit');
    
    // Open edit modal
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.edit-task');
        if (!btn) return;
        
        const taskId = btn.dataset.id;
        
        try {
            // Fetch task data
            const res = await fetch(`/tasks/${taskId}`);
            if (!res.ok) throw new Error('Не удалось загрузить задачу');
            
            const data = await res.json();
            const task = data.task;
            
            // Populate form
            document.getElementById('edit-title').value = task.title;
            document.getElementById('edit-description').value = task.description || '';
            document.getElementById('edit-due_date').value = task.due_date || '';
            document.getElementById('edit-priority').value = task.priority || 'medium';
            document.getElementById('edit-completed').checked = task.completed;
            
            // Set form action
            editForm.action = `/tasks/${taskId}`;
            
            // Show modal
            editModal.classList.remove('hidden');
        } catch (error) {
            console.error('Ошибка:', error);
            alert('Не удалось загрузить данные задачи');
        }
    });
    
    // Close modal
    cancelEdit.addEventListener('click', () => {
        editModal.classList.add('hidden');
    });
    
    // Close modal when clicking outside
    editModal.addEventListener('click', (e) => {
        if (e.target === editModal) {
            editModal.classList.add('hidden');
        }
    });
    
    // Save edited task
    editForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(editForm);
        const data = {
            title: formData.get('title'),
            description: formData.get('description') || null,
            due_date: formData.get('due_date') || null,
            priority: formData.get('priority') || 'medium',
            completed: formData.get('completed') === '1'
        };
        
        try {
            const res = await fetch(editForm.action, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            });
            
            if (res.ok) {
                window.location.reload();
            } else {
                const error = await res.json();
                alert(error.message || 'Ошибка при сохранении задачи');
            }
        } catch (error) {
            console.error('Ошибка:', error);
            alert('Ошибка при сохранении задачи');
        }
    });

    // Toggle task completion
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
                // Restore previous state
                e.target.checked = !completed;
            }
        }
    });

    // Delete task
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