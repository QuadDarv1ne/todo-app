<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">🎮 Игровой прогресс</h3>
            <a href="{{ route('achievements.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">
                Все достижения →
            </a>
        </div>

        <!-- Уровень и опыт -->
        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-950/40 dark:to-purple-950/40 rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Уровень</div>
                    <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ auth()->user()->level }}</div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-600 dark:text-gray-400">Опыт</div>
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ auth()->user()->experience_points }} XP</div>
                </div>
            </div>

            @php
                $currentLevel = auth()->user()->level;
                $currentXP = auth()->user()->experience_points;
                $currentLevelXP = pow($currentLevel, 2) * 100;
                $nextLevelXP = pow($currentLevel + 1, 2) * 100;
                $levelProgress = $nextLevelXP > $currentLevelXP 
                    ? (($currentXP - $currentLevelXP) / ($nextLevelXP - $currentLevelXP)) * 100 
                    : 0;
            @endphp

            @php
                $progressValue = min($levelProgress, 100);
                $progressClass = $progressValue >= 100 ? 'w-full' : ($progressValue >= 75 ? 'w-3/4' : ($progressValue >= 50 ? 'w-1/2' : ($progressValue >= 25 ? 'w-1/4' : 'w-0')));
            @endphp

            <div class="w-full bg-white dark:bg-gray-700 rounded-full h-3 overflow-hidden shadow-inner">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full transition-all duration-500 {{ $progressClass }}"></div>
            </div>
            <div class="text-xs text-gray-600 dark:text-gray-400 mt-1 text-center">
                {{ number_format($currentXP - $currentLevelXP) }} / {{ number_format($nextLevelXP - $currentLevelXP) }} XP
                ({{ number_format($levelProgress, 1) }}%)
            </div>
        </div>

        <!-- Статистика -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div class="bg-green-50 dark:bg-green-900/30 rounded-lg p-3">
                <div class="text-xs text-green-700 dark:text-green-400 font-medium">Серия дней</div>
                <div class="text-xl font-bold text-green-900 dark:text-green-300">{{ auth()->user()->streak_days }} 🔥</div>
            </div>
            <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-3">
                <div class="text-xs text-blue-700 dark:text-blue-400 font-medium">Достижения</div>
                <div class="text-xl font-bold text-blue-900 dark:text-blue-300">
                    {{ auth()->user()->achievements->count() }} / {{ \App\Models\Achievement::count() }}
                </div>
            </div>
        </div>

        <!-- Последние достижения -->
        @php
            $recentAchievements = auth()->user()->achievements()
                ->orderBy('user_achievements.unlocked_at', 'desc')
                ->take(3)
                ->get();
        @endphp

        @if($recentAchievements->isNotEmpty())
            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">Недавние достижения</h4>
                <div class="space-y-2">
                    @foreach($recentAchievements as $achievement)
                        <div class="flex items-center bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-950/30 dark:to-orange-950/30 rounded-lg p-2 border border-yellow-200 dark:border-yellow-700">
                            <span class="text-2xl mr-2">{{ $achievement->icon }}</span>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">
                                    {{ $achievement->name }}
                                </div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">
                                    +{{ $achievement->points }} XP
                                </div>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($achievement->pivot->unlocked_at)->diffForHumans() }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
                    Выполняйте задачи, чтобы открыть достижения! 🎯
                </p>
            </div>
        @endif
    </div>
</div>
