@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Добро пожаловать, {{ Auth::user()->name }}!</h3>
                        
                        <!-- Stats Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <x-stats-card 
                                title="Всего задач"
                                :value="$totalTasks"
                                description="Все ваши задачи"
                                color="blue"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </x-stats-card>
                            
                            <x-stats-card 
                                title="Активные"
                                :value="$pendingTasks"
                                description="Еще не завершены"
                                color="yellow"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </x-stats-card>
                            
                            <x-stats-card 
                                title="Завершены"
                                :value="$completedTasks"
                                description="Выполненные задачи"
                                color="green"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </x-stats-card>
                        </div>
                        
                        <!-- Progress Section -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                            <!-- Progress Bar -->
                            @if($totalTasks > 0)
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <x-progress-bar 
                                    :percentage="$completionPercentage"
                                    label="Прогресс выполнения"
                                >
                                    {{ $completedTasks }} из {{ $totalTasks }} задач выполнено
                                </x-progress-bar>
                                
                                <!-- Completion Stats -->
                                <div class="mt-6 grid grid-cols-2 gap-4">
                                    <div class="text-center p-3 bg-green-50 rounded-lg">
                                        <div class="text-2xl font-bold text-green-600">{{ $completedTasks }}</div>
                                        <div class="text-sm text-green-700">Завершено</div>
                                    </div>
                                    <div class="text-center p-3 bg-yellow-50 rounded-lg">
                                        <div class="text-2xl font-bold text-yellow-600">{{ $pendingTasks }}</div>
                                        <div class="text-sm text-yellow-700">В процессе</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Activity Chart -->
                            @if($tasksByDay->count() > 0)
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Активность за неделю</h3>
                                <div class="h-40 flex items-end justify-between gap-2">
                                    @foreach($tasksByDay as $day)
                                        <div class="flex flex-col items-center flex-1">
                                            <div class="w-full bg-gray-200 rounded-t-lg overflow-hidden" style="height: 80px;">
                                                <div class="bg-indigo-500 w-full rounded-t-lg" 
                                                     style="height: <?php echo ($tasksByDay->max('count') > 0) ? ($day->count / $tasksByDay->max('count')) * 100 : 0; ?>%"></div>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-2">
                                                {{ \Carbon\Carbon::parse($day->date)->format('d.m') }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Recent Tasks -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Последние задачи</h3>
                                <a href="{{ route('tasks.index') }}" 
                                   class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                    Просмотреть все
                                </a>
                            </div>
                            
                            @if($recentTasks->count() > 0)
                                <div class="space-y-3">
                                    @foreach($recentTasks as $task)
                                        <x-task-card :task="$task" :show-actions="false" />
                                    @endforeach
                                </div>
                                <div class="mt-6">
                                    <a href="{{ route('tasks.index') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Просмотреть все задачи
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Нет задач</h3>
                                    <p class="mt-1 text-sm text-gray-500">Начните с создания своей первой задачи.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('tasks.index') }}" 
                                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Создать задачу
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle task completion
            document.querySelectorAll('.task-toggle').forEach(checkbox => {
                checkbox.addEventListener('change', async function() {
                    const taskId = this.dataset.taskId;
                    const completed = this.checked;
                    
                    try {
                        const response = await fetch(`/tasks/${taskId}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ completed: completed })
                        });
                        
                        if (!response.ok) {
                            throw new Error('Failed to update task');
                        }
                        
                        // Reload the page to reflect changes
                        window.location.reload();
                    } catch (error) {
                        console.error('Error updating task:', error);
                        // Revert the checkbox state
                        this.checked = !completed;
                        alert('Ошибка при обновлении задачи');
                    }
                });
            });
        });
    </script>
    @endpush
@endsection