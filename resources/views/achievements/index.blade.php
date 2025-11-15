<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Достижения') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Информация пользователя -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ auth()->user()->name }}</h3>
                            <p class="text-gray-600 mt-1">Уровень {{ auth()->user()->level }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-indigo-600">{{ auth()->user()->experience_points }} XP</div>
                            <p class="text-sm text-gray-500">
                                До уровня {{ auth()->user()->level + 1 }}: 
                                {{ (pow(auth()->user()->level + 1, 2) * 100) - auth()->user()->experience_points }} XP
                            </p>
                        </div>
                    </div>

                    <!-- Прогресс-бар опыта -->
                    @php
                        $currentLevel = auth()->user()->level;
                        $currentXP = auth()->user()->experience_points;
                        $currentLevelXP = pow($currentLevel, 2) * 100;
                        $nextLevelXP = pow($currentLevel + 1, 2) * 100;
                        $levelProgress = $nextLevelXP > $currentLevelXP 
                            ? (($currentXP - $currentLevelXP) / ($nextLevelXP - $currentLevelXP)) * 100 
                            : 0;
                    @endphp
                    <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-4 rounded-full transition-all duration-500 flex items-center justify-center text-xs text-white font-semibold"
                             style="width: {{ min($levelProgress, 100) }}%">
                            {{ number_format($levelProgress, 1) }}%
                        </div>
                    </div>

                    <!-- Статистика -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg">
                            <div class="text-sm text-blue-700 font-medium">Открыто достижений</div>
                            <div class="text-2xl font-bold text-blue-900">
                                {{ auth()->user()->achievements->count() }} / {{ $achievements->count() }}
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-lg">
                            <div class="text-sm text-green-700 font-medium">Дней подряд</div>
                            <div class="text-2xl font-bold text-green-900">
                                {{ auth()->user()->streak_days }} 🔥
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-lg">
                            <div class="text-sm text-purple-700 font-medium">Общий прогресс</div>
                            <div class="text-2xl font-bold text-purple-900">
                                {{ number_format((auth()->user()->achievements->count() / max($achievements->count(), 1)) * 100, 1) }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Список достижений по категориям -->
            @foreach($achievementsByCategory as $category => $categoryAchievements)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            @switch($category)
                                @case('tasks')
                                    <span class="mr-2">📋</span> Задачи
                                    @break
                                @case('productivity')
                                    <span class="mr-2">⚡</span> Продуктивность
                                    @break
                                @case('social')
                                    <span class="mr-2">👥</span> Социальные
                                    @break
                                @case('streak')
                                    <span class="mr-2">🔥</span> Серии
                                    @break
                                @case('special')
                                    <span class="mr-2">⭐</span> Особые
                                    @break
                                @default
                                    <span class="mr-2">🎯</span> {{ ucfirst($category) }}
                            @endswitch
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($categoryAchievements as $achievement)
                                @php
                                    $isUnlocked = auth()->user()->achievements->contains($achievement->id);
                                    $unlockedAt = $isUnlocked 
                                        ? auth()->user()->achievements->find($achievement->id)->pivot->unlocked_at 
                                        : null;
                                @endphp
                                <div class="border rounded-lg p-4 transition-all duration-300 {{ $isUnlocked ? 'border-green-300 bg-green-50' : 'border-gray-200 bg-gray-50' }}">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center">
                                            <span class="text-3xl mr-3 {{ $isUnlocked ? '' : 'grayscale opacity-50' }}">
                                                {{ $achievement->icon }}
                                            </span>
                                            <div>
                                                <h4 class="font-bold text-gray-900">{{ $achievement->name }}</h4>
                                                @if($isUnlocked)
                                                    <p class="text-xs text-green-600 font-medium">
                                                        ✓ Открыто
                                                    </p>
                                                @else
                                                    <p class="text-xs text-gray-500">
                                                        Заблокировано
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="bg-indigo-600 text-white text-xs font-bold px-2 py-1 rounded">
                                            +{{ $achievement->points }} XP
                                        </span>
                                    </div>

                                    <p class="text-sm text-gray-700 mb-3 {{ $isUnlocked ? '' : 'opacity-75' }}">
                                        {{ $achievement->description }}
                                    </p>

                                    @if($isUnlocked && $unlockedAt)
                                        <div class="text-xs text-gray-600 border-t pt-2 mt-2">
                                            <span class="font-medium">Открыто:</span> 
                                            {{ \Carbon\Carbon::parse($unlockedAt)->format('d.m.Y H:i') }}
                                        </div>
                                    @endif

                                    @if(!$isUnlocked && !$achievement->is_secret)
                                        <div class="mt-3 pt-3 border-t border-gray-200">
                                            <p class="text-xs text-gray-600 font-medium mb-1">Требования:</p>
                                            <ul class="text-xs text-gray-600 space-y-1">
                                                @if(isset($achievement->requirements['tasks_completed']))
                                                    <li>• Выполнить {{ $achievement->requirements['tasks_completed'] }} задач</li>
                                                @endif
                                                @if(isset($achievement->requirements['completion_rate']))
                                                    <li>• Достичь {{ $achievement->requirements['completion_rate'] }}% выполнения</li>
                                                @endif
                                                @if(isset($achievement->requirements['tags_used']))
                                                    <li>• Использовать {{ $achievement->requirements['tags_used'] }} тегов</li>
                                                @endif
                                                @if(isset($achievement->requirements['streak_days']))
                                                    <li>• Поддерживать серию {{ $achievement->requirements['streak_days'] }} дней</li>
                                                @endif
                                                @if(isset($achievement->requirements['level']))
                                                    <li>• Достичь уровня {{ $achievement->requirements['level'] }}</li>
                                                @endif
                                            </ul>
                                        </div>
                                    @endif

                                    @if(!$isUnlocked && $achievement->is_secret)
                                        <div class="mt-3 pt-3 border-t border-gray-200">
                                            <p class="text-xs text-gray-500 italic">🔒 Секретное достижение</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

            @if($achievements->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        Достижения пока не добавлены. Выполняйте задачи, чтобы открыть новые достижения!
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
