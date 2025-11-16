<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Статистика') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Общая статистика -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Всего задач</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['advanced']['total'] }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Выполнено</p>
                            <p class="text-3xl font-bold text-green-600">{{ $stats['advanced']['completed'] }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">В процессе</p>
                            <p class="text-3xl font-bold text-yellow-600">{{ $stats['advanced']['pending'] }}</p>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Просрочено</p>
                            <p class="text-3xl font-bold text-red-600">{{ $stats['advanced']['overdue'] }}</p>
                        </div>
                        <div class="bg-red-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Вторая строка статистики -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Процент выполнения</h3>
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-green-600 bg-green-200">
                                    Прогресс
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-semibold inline-block text-green-600">
                                    {{ $stats['advanced']['completion_rate'] }}%
                                </span>
                            </div>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-green-200">
                            <div style="width:{{ $stats['advanced']['completion_rate'] }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500"></div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Среднее время выполнения</h3>
                    <p class="text-3xl font-bold text-gray-900">
                        @if($stats['advanced']['avg_completion_time'])
                            {{ $stats['advanced']['avg_completion_time'] }} <span class="text-base text-gray-600">часов</span>
                        @else
                            <span class="text-base text-gray-600">Нет данных</span>
                        @endif
                    </p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Активность (7 дней)</h3>
                    <p class="text-sm text-gray-600 mb-2">Создано: <span class="font-bold text-gray-900">{{ $stats['advanced']['tasks_created_last_7_days'] }}</span></p>
                    <p class="text-sm text-gray-600">Завершено: <span class="font-bold text-gray-900">{{ $stats['advanced']['tasks_completed_last_7_days'] }}</span></p>
                </div>
            </div>

            <!-- Новые метрики -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Показатель продуктивности</h3>
                    <div class="flex items-center justify-between">
                        <p class="text-3xl font-bold text-indigo-600">{{ round($stats['advanced']['productivity_score']) }}%</p>
                        <div class="w-16 h-16">
                            <canvas id="productivityChart"></canvas>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Общий показатель эффективности</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Задачи с тегами</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ $stats['advanced']['with_tags'] }}</p>
                    <div class="mt-4">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm text-gray-600">Процент</span>
                            <span class="text-sm font-medium text-gray-900">{{ $stats['advanced']['total'] > 0 ? round(($stats['advanced']['with_tags'] / $stats['advanced']['total']) * 100) : 0 }}%</span>
                        </div>
                        <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                            <div style="width:{{ $stats['advanced']['total'] > 0 ? round(($stats['advanced']['with_tags'] / $stats['advanced']['total']) * 100) : 0 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-purple-500"></div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Тренд выполнения</h3>
                    <div class="flex items-center">
                        @php
                            $trendData = array_values($stats['advanced']['completion_trend']);
                            $lastWeek = array_slice($trendData, -7);
                            $trendSum = array_sum($lastWeek);
                            $prevWeek = array_slice($trendData, -14, 7);
                            $prevSum = array_sum($prevWeek);
                            $trendChange = $prevSum > 0 ? round((($trendSum - $prevSum) / $prevSum) * 100) : 0;
                        @endphp
                        <p class="text-3xl font-bold {{ $trendChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $trendSum }}
                        </p>
                        <div class="ml-4">
                            <div class="flex items-center {{ $trendChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                <svg class="w-5 h-5 {{ $trendChange >= 0 ? '' : 'transform rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium">{{ abs($trendChange) }}%</span>
                            </div>
                            <p class="text-xs text-gray-600 mt-1">за последние 7 дней</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Приоритеты и теги -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Распределение по приоритетам</h3>
                    <div class="h-64">
                        <canvas id="priorityChart"></canvas>
                    </div>
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 rounded-full bg-red-500 mr-2"></span>
                                <span class="text-sm text-gray-700">Высокий приоритет</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ $stats['advanced']['tasks_by_priority']['high'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>
                                <span class="text-sm text-gray-700">Средний приоритет</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ $stats['advanced']['tasks_by_priority']['medium'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 rounded-full bg-green-500 mr-2"></span>
                                <span class="text-sm text-gray-700">Низкий приоритет</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ $stats['advanced']['tasks_by_priority']['low'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Популярные теги</h3>
                    <div class="h-64">
                        <canvas id="tagsChart"></canvas>
                    </div>
                    <div class="mt-4 space-y-3">
                        @forelse($stats['tags'] as $tag)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="inline-block w-3 h-3 rounded-full mr-2" style="background-color: {{ $tag['color'] }}"></span>
                                    <span class="text-sm text-gray-700">{{ $tag['name'] }}</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $tag['tasks_count'] }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic">Теги не найдены</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Графики по времени -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <!-- Heat Map активности -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Heat Map активности (365 дней)
                    </h3>
                    <div id="activityHeatmap" class="overflow-x-auto"></div>
                </div>

                <!-- Продуктивность по дням недели -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Продуктивность по дням недели</h3>
                    <div class="h-64">
                        <canvas id="weeklyProductivityChart"></canvas>
                    </div>
                </div>

                <!-- Тренд выполнения за 30 дней -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Тренд выполнения (30 дней)</h3>
                    <div class="h-64">
                        <canvas id="completionTrendChart"></canvas>
                    </div>
                </div>

                <!-- Активность по часам -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Активность по часам</h3>
                    <div class="h-64">
                        <canvas id="hourlyActivityChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- График по дням недели -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Создание задач по дням недели</h3>
                <div class="grid grid-cols-7 gap-2">
                    @foreach($stats['by_day_of_week'] as $day => $count)
                        <div class="text-center">
                            <div class="bg-blue-100 rounded-lg p-4 mb-2 h-32 flex items-end justify-center">
                                <div class="bg-blue-500 rounded-t w-full transition-all" style="height: {{ $count > 0 ? min(100, ($count / max($stats['by_day_of_week'])) * 100) : 5 }}%"></div>
                            </div>
                            <p class="text-xs font-semibold text-gray-700">{{ $day }}</p>
                            <p class="text-xs text-gray-500">{{ $count }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Productivity Score Chart
            const productivityCtx = document.getElementById('productivityChart').getContext('2d');
            const productivityChart = new Chart(productivityCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Продуктивность', 'Оставшееся'],
                    datasets: [{
                        data: [{{ round($stats['advanced']['productivity_score']) }}, {{ 100 - round($stats['advanced']['productivity_score']) }}],
                        backgroundColor: [
                            '#6366f1',
                            '#e5e7eb'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Priority Distribution Chart
            const priorityCtx = document.getElementById('priorityChart').getContext('2d');
            const priorityChart = new Chart(priorityCtx, {
                type: 'bar',
                data: {
                    labels: ['Высокий', 'Средний', 'Низкий'],
                    datasets: [{
                        label: 'Количество задач',
                        data: [
                            {{ $stats['advanced']['tasks_by_priority']['high'] }},
                            {{ $stats['advanced']['tasks_by_priority']['medium'] }},
                            {{ $stats['advanced']['tasks_by_priority']['low'] }}
                        ],
                        backgroundColor: [
                            '#ef4444',
                            '#f59e0b',
                            '#10b981'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Tags Chart
            const tagsCtx = document.getElementById('tagsChart').getContext('2d');
            const tagsData = [
                @foreach($stats['tags'] as $tag)
                    {{ $tag['tasks_count'] }},
                @endforeach
            ];
            const tagsLabels = [
                @foreach($stats['tags'] as $tag)
                    '{{ $tag['name'] }}',
                @endforeach
            ];
            const tagsColors = [
                @foreach($stats['tags'] as $tag)
                    '{{ $tag['color'] }}',
                @endforeach
            ];

            const tagsChart = new Chart(tagsCtx, {
                type: 'doughnut',
                data: {
                    labels: tagsLabels,
                    datasets: [{
                        data: tagsData,
                        backgroundColor: tagsColors
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });

            // Completion Trend Chart
            const trendCtx = document.getElementById('completionTrendChart').getContext('2d');
            const trendDates = Object.keys({!! json_encode($stats['advanced']['completion_trend']) !!});
            const trendValues = Object.values({!! json_encode($stats['advanced']['completion_trend']) !!});

            const trendChart = new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: trendDates.map(date => {
                        const d = new Date(date);
                        return d.toLocaleDateString('ru-RU', { day: 'numeric', month: 'short' });
                    }),
                    datasets: [{
                        label: 'Завершенные задачи',
                        data: trendValues,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            // Hourly Activity Chart
            const hourlyCtx = document.getElementById('hourlyActivityChart').getContext('2d');
            const hourlyData = [
                @foreach($stats['advanced']['tasks_by_hour'] as $hour => $count)
                    {{ $count }},
                @endforeach
            ];

            const hourlyChart = new Chart(hourlyCtx, {
                type: 'bar',
                data: {
                    labels: Array.from({length: 24}, (_, i) => `${i}:00`),
                    datasets: [{
                        label: 'Создано задач',
                        data: hourlyData,
                        backgroundColor: '#8b5cf6',
                        borderColor: '#7c3aed',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        },
                        x: {
                            ticks: {
                                maxRotation: 0,
                                autoSkip: true,
                                maxTicksLimit: 12
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
