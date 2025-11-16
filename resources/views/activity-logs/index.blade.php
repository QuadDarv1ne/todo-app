<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('История активности') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Статистика активности -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">Всего действий</div>
                    <div class="text-3xl font-bold text-indigo-600 mt-2">{{ $stats['total_actions'] }}</div>
                </div>

                @if(isset($stats['most_active_day']) && $stats['most_active_day'])
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">Самый активный день</div>
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 mt-2">
                        {{ \Carbon\Carbon::parse($stats['most_active_day'])->format('d.m.Y') }}
                    </div>
                </div>
                @endif

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">Создано задач</div>
                    <div class="text-3xl font-bold text-green-600 mt-2">
                        {{ $stats['actions_by_type']['created'] ?? 0 }}
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">Завершено задач</div>
                    <div class="text-3xl font-bold text-blue-600 mt-2">
                        {{ $stats['actions_by_type']['completed'] ?? 0 }}
                    </div>
                </div>
            </div>

            <!-- Фильтры -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Фильтры</h3>
                    <form method="GET" action="{{ route('activity-logs.index') }}" class="flex flex-wrap gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Тип действия</label>
                            <select name="action" class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">Все</option>
                                <option value="created" {{ request('action') === 'created' ? 'selected' : '' }}>Создано</option>
                                <option value="updated" {{ request('action') === 'updated' ? 'selected' : '' }}>Обновлено</option>
                                <option value="deleted" {{ request('action') === 'deleted' ? 'selected' : '' }}>Удалено</option>
                                <option value="completed" {{ request('action') === 'completed' ? 'selected' : '' }}>Завершено</option>
                                <option value="achievement_unlocked" {{ request('action') === 'achievement_unlocked' ? 'selected' : '' }}>Достижения</option>
                                <option value="level_up" {{ request('action') === 'level_up' ? 'selected' : '' }}>Повышение уровня</option>
                            </select>
                        </div>

                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Тип объекта</label>
                            <select name="model_type" class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">Все</option>
                                <option value="App\Models\Task" {{ request('model_type') === 'App\Models\Task' ? 'selected' : '' }}>Задачи</option>
                                <option value="App\Models\Achievement" {{ request('model_type') === 'App\Models\Achievement' ? 'selected' : '' }}>Достижения</option>
                                <option value="App\Models\User" {{ request('model_type') === 'App\Models\User' ? 'selected' : '' }}>Пользователь</option>
                            </select>
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-500 transition-colors">
                                Применить
                            </button>
                            <a href="{{ route('activity-logs.index') }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                Сбросить
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Список логов -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">История действий</h3>

                    @forelse($logs as $log)
                        <div class="border-l-4 border-{{ $log->action_color }}-500 bg-{{ $log->action_color }}-50 dark:bg-{{ $log->action_color }}-900/30 p-4 mb-4 rounded-r-lg">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-3 flex-1">
                                    <span class="text-2xl">{{ $log->action_icon }}</span>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $log->action_label }}</span>
                                            <span class="text-xs px-2 py-1 bg-{{ $log->action_color }}-200 text-{{ $log->action_color }}-800 dark:bg-{{ $log->action_color }}-900/30 dark:text-{{ $log->action_color }}-300 rounded-full">
                                                {{ class_basename($log->model_type ?? 'System') }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $log->description }}</p>
                                        
                                        @if($log->properties && count($log->properties) > 0)
                                            <details class="mt-2">
                                                <summary class="text-xs text-gray-600 dark:text-gray-400 cursor-pointer hover:text-gray-800 dark:hover:text-gray-200">
                                                    Подробности
                                                </summary>
                                                <div class="mt-2 bg-white dark:bg-gray-900 rounded p-3 text-xs text-gray-800 dark:text-gray-200">
                                                    <pre class="overflow-x-auto">{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                </div>
                                            </details>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $log->created_at->format('d.m.Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $log->created_at->format('H:i:s') }}
                                    </div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                        {{ $log->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>

                            @if($log->ip_address)
                                <div class="mt-2 pt-2 border-t border-{{ $log->action_color }}-200 dark:border-{{ $log->action_color }}-700 text-xs text-gray-600 dark:text-gray-400">
                                    <span class="font-medium">IP:</span> {{ $log->ip_address }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Нет записей</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">История ваших действий появится здесь.</p>
                        </div>
                    @endforelse

                    <!-- Пагинация -->
                    @if($logs->hasPages())
                        <div class="mt-6">
                            {{ $logs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
