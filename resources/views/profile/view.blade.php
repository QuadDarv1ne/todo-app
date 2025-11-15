<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Мой профиль') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- User Profile Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl mb-8">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            @if($user->avatar_path)
                                <img class="h-24 w-24 rounded-full object-cover" src="{{ asset('storage/avatars/' . $user->avatar_path) }}" alt="{{ $user->name }}" />
                            @else
                                <div class="h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <span class="text-3xl font-bold text-indigo-700">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- User Info -->
                        <div class="flex-1 text-center md:text-left">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-lg text-gray-600 mt-2">{{ $user->email }}</p>
                            
                            <!-- Bio -->
                            @if($user->bio)
                                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                    <p class="text-gray-700 whitespace-pre-line">{{ $user->bio }}</p>
                                </div>
                            @else
                                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                    <p class="text-gray-500 italic">Пользователь пока не добавил биографию</p>
                                </div>
                            @endif
                            
                            <!-- Stats -->
                            <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <div class="text-2xl font-bold text-blue-700">{{ $taskStats['total'] }}</div>
                                    <div class="text-sm text-blue-600">Всего задач</div>
                                </div>
                                <div class="bg-green-50 rounded-lg p-4">
                                    <div class="text-2xl font-bold text-green-700">{{ $taskStats['completed'] }}</div>
                                    <div class="text-sm text-green-600">Завершено</div>
                                </div>
                                <div class="bg-yellow-50 rounded-lg p-4">
                                    <div class="text-2xl font-bold text-yellow-700">{{ $taskStats['pending'] }}</div>
                                    <div class="text-sm text-yellow-600">В процессе</div>
                                </div>
                                <div class="bg-purple-50 rounded-lg p-4">
                                    <div class="text-2xl font-bold text-purple-700">{{ $taskStats['completion_percentage'] }}%</div>
                                    <div class="text-sm text-purple-600">Прогресс</div>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <a href="{{ route('profile.edit') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                    Редактировать профиль
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                            </div>
            
            <!-- Stats and Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Task Completion Chart -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Статус задач</h3>
                        <div class="flex items-center justify-center h-64">
                            <canvas id="taskCompletionChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Activity Chart -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Активность за неделю</h3>
                        <div class="flex items-end justify-between h-64 gap-2">
                            @if($tasksByDay->count() > 0)
                                @foreach($tasksByDay as $day)
                                    <div class="flex flex-col items-center flex-1">
                                        <div class="w-full bg-gray-200 rounded-t-lg overflow-hidden" style="height: 200px;">
                                            <div class="bg-indigo-500 w-full rounded-t-lg" 
                                                 style="height: <?php echo e(($tasksByDay->max('count') > 0) ? ($day->count / $tasksByDay->max('count')) * 100 : 0); ?>%"></div>
                                        </div>
                                        <div class="text-sm text-gray-500 mt-3">
                                            {{ \Carbon\Carbon::parse($day->date)->format('d.m') }}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center text-gray-500 w-full py-8">
                                    Нет данных об активности
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Donation Stats -->
            <div class="mt-8 bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Статистика донатов</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-indigo-50 rounded-xl p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-indigo-100 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $donationStats['count'] }}</h4>
                                    <p class="text-sm text-gray-600">Всего донатов</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-green-50 rounded-xl p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-green-100 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $donationStats['amount'] }}</h4>
                                    <p class="text-sm text-gray-600">Общая сумма</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-purple-50 rounded-xl p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-purple-100 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-2xl font-bold text-gray-900">{{ $donationStats['currencies'] }}</h4>
                                    <p class="text-sm text-gray-600">Валюты</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Task Completion Chart
            const ctx = document.getElementById('taskCompletionChart').getContext('2d');
            const taskChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Завершено', 'В процессе'],
                    datasets: [{
                        data: [<?php echo e($completionStats['completed']); ?>, <?php echo e($completionStats['pending']); ?>],
                        backgroundColor: [
                            '#10B981',
                            '#F59E0B'
                        ],
                        borderColor: [
                            '#059669',
                            '#D97706'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>