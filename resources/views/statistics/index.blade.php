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

            <!-- Приоритеты и теги -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Распределение по приоритетам</h3>
                    <div class="space-y-3">
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
                    <div class="space-y-3">
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

            <!-- График по дням недели -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
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
</x-app-layout>
