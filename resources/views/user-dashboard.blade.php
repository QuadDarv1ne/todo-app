@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">👋 Добро пожаловать, {{ Auth::user()->name }}!</h1>
                        <p class="mt-2 text-gray-600">Вот обзор вашей продуктивности</p>
                    </div>
                    <div class="hidden md:flex items-center space-x-3">
                        <span class="text-sm text-gray-500">Сегодня</span>
                        <span class="text-lg font-semibold text-indigo-600">{{ \Carbon\Carbon::now()->format('d M, Y') }}</span>
                    </div>
                </div>
            </div>
                        
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Всего задач</p>
                            <p class="text-3xl font-bold mt-2">{{ $totalTasks }}</p>
                            <p class="text-blue-100 text-xs mt-1">Все ваши задачи</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm font-medium">Активные</p>
                            <p class="text-3xl font-bold mt-2">{{ $pendingTasks }}</p>
                            <p class="text-yellow-100 text-xs mt-1">Еще не завершены</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Завершены</p>
                            <p class="text-3xl font-bold mt-2">{{ $completedTasks }}</p>
                            <p class="text-green-100 text-xs mt-1">Выполненные задачи</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                @if($donationStats['count'] > 0)
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Донаты</p>
                                <p class="text-3xl font-bold mt-2">{{ $donationStats['count'] }}</p>
                                <p class="text-purple-100 text-xs mt-1">{{ number_format($donationStats['amount'], 2) }} ₽</p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-full p-3">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-indigo-100 text-sm font-medium">Донаты</p>
                                <p class="text-3xl font-bold mt-2">0</p>
                                <p class="text-indigo-100 text-xs mt-1">
                                    <a href="{{ route('donations.my') }}" class="hover:underline">Создать первый →</a>
                                </p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-full p-3">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
                        
                        <!-- Рекомендации и умные подсказки -->
                        <x-dashboard-recommendations />
                        
                        <!-- Игровой прогресс -->
                        <x-dashboard-gamification />
                        
                        <!-- Недавняя активность -->
                        <x-dashboard-activity />
                        
                        <!-- Progress Section -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
                            <!-- Progress Bar -->
                            @if($totalTasks > 0)
                            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                                <x-progress-bar 
                                    :percentage="$completionPercentage"
                                    label="Прогресс выполнения"
                                >
                                    {{ $completedTasks }} из {{ $totalTasks }} задач выполнено
                                </x-progress-bar>
                                
                                <!-- Completion Stats -->
                                <div class="mt-8 grid grid-cols-2 gap-4">
                                    <div class="text-center p-4 bg-green-50 rounded-xl">
                                        <div class="text-3xl font-bold text-green-600">{{ $completedTasks }}</div>
                                        <div class="text-base text-green-700 mt-1">Завершено</div>
                                    </div>
                                    <div class="text-center p-4 bg-yellow-50 rounded-xl">
                                        <div class="text-3xl font-bold text-yellow-600">{{ $pendingTasks }}</div>
                                        <div class="text-base text-yellow-700 mt-1">В процессе</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Activity Chart -->
                            @if($tasksByDay->count() > 0)
                            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6">Активность за неделю</h3>
                                <div class="h-48 flex items-end justify-between gap-3">
                                    @foreach($tasksByDay as $day)
                                        <div class="flex flex-col items-center flex-1">
                                            <div class="w-full bg-gray-200 rounded-t-lg overflow-hidden" style="height: 120px;">
                                                <div class="bg-indigo-500 w-full rounded-t-lg" 
                                                     style="height: <?php echo ($tasksByDay->max('count') > 0) ? ($day->count / $tasksByDay->max('count')) * 100 : 0; ?>%"></div>
                                            </div>
                                            <div class="text-sm text-gray-500 mt-3">
                                                {{ \Carbon\Carbon::parse($day->date)->format('d.m') }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Recent Tasks -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-semibold text-gray-900">Последние задачи</h3>
                                <a href="{{ route('tasks.index') }}" 
                                   class="text-base text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200">
                                    Просмотреть все
                                </a>
                            </div>
                            
                            @if($recentTasks->count() > 0)
                                <div class="space-y-4">
                                    @foreach($recentTasks as $task)
                                        <x-task-card :task="$task" :show-actions="false" />
                                    @endforeach
                                </div>
                                <div class="mt-8">
                                    <a href="{{ route('tasks.index') }}" 
                                       class="inline-flex items-center px-5 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        Просмотреть все задачи
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <h3 class="mt-4 text-xl font-medium text-gray-900">Нет задач</h3>
                                    <p class="mt-2 text-gray-600">Начните с создания своей первой задачи.</p>
                                    <div class="mt-8">
                                        <a href="{{ route('tasks.index') }}" 
                                           class="inline-flex items-center px-5 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                            Создать задачу
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        </div>
                    </div>
                </div>
            @endif
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