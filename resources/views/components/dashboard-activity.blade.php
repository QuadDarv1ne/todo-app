<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">📊 Недавняя активность</h3>
            <a href="{{ route('activity-logs.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">
                Вся история →
            </a>
        </div>

        @php
            $recentLogs = auth()->user()->activityLogs()->take(5)->get();
        @endphp

        @if($recentLogs->isNotEmpty())
            <div class="space-y-3">
                @foreach($recentLogs as $log)
                    <div class="border-l-4 border-{{ $log->action_color }}-500 bg-{{ $log->action_color }}-50 dark:bg-{{ $log->action_color }}-900/30 p-3 rounded-r-lg">
                        <div class="flex items-start gap-2">
                            <span class="text-xl">{{ $log->action_icon }}</span>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $log->action_label }}</span>
                                    @if($log->model_type)
                                        <span class="text-xs px-2 py-0.5 bg-{{ $log->action_color }}-200 text-{{ $log->action_color }}-800 dark:bg-{{ $log->action_color }}-900/30 dark:text-{{ $log->action_color }}-300 rounded-full">
                                            {{ class_basename($log->model_type) }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-700 dark:text-gray-300 line-clamp-2">{{ $log->description }}</p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $log->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Краткая статистика -->
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-3 gap-2 text-center">
                    <div class="bg-green-50 dark:bg-green-900/30 rounded p-2">
                        <div class="text-xs text-green-700 dark:text-green-400 font-medium">Создано</div>
                        <div class="text-lg font-bold text-green-900 dark:text-green-300">
                            {{ auth()->user()->activityLogs()->where('action', 'created')->count() }}
                        </div>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900/30 rounded p-2">
                        <div class="text-xs text-blue-700 dark:text-blue-400 font-medium">Завершено</div>
                        <div class="text-lg font-bold text-blue-900 dark:text-blue-300">
                            {{ auth()->user()->activityLogs()->where('action', 'completed')->count() }}
                        </div>
                    </div>
                    <div class="bg-purple-50 dark:bg-purple-900/30 rounded p-2">
                        <div class="text-xs text-purple-700 dark:text-purple-400 font-medium">Достижений</div>
                        <div class="text-lg font-bold text-purple-900 dark:text-purple-300">
                            {{ auth()->user()->activityLogs()->where('action', 'achievement_unlocked')->count() }}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">История активности пока пуста</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">Выполняйте задачи, чтобы увидеть свою активность!</p>
            </div>
        @endif
    </div>
</div>
