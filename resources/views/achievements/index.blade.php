<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Достижения') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-950 py-12 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-2">
                    <div class="bg-yellow-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Достижения</h1>
                        <p class="text-gray-600">Отслеживайте свой прогресс и открывайте награды</p>
                    </div>
                </div>
            </div>

            <!-- User Progress Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 mb-8 overflow-hidden transition-colors duration-300">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="text-white">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="bg-white bg-opacity-20 rounded-full p-3">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold">{{ auth()->user()->name }}</h3>
                                    <p class="text-indigo-100 text-sm">Уровень {{ auth()->user()->level }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right text-white">
                            <div class="text-4xl font-bold mb-1">{{ auth()->user()->experience_points }} XP</div>
                            <p class="text-sm text-indigo-100">
                                До уровня {{ auth()->user()->level + 1 }}: 
                                {{ (pow(auth()->user()->level + 1, 2) * 100) - auth()->user()->experience_points }} XP
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6">

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
                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span class="font-medium">Прогресс до следующего уровня</span>
                            <span class="font-semibold text-indigo-600">{{ number_format($levelProgress, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-6 overflow-hidden shadow-inner">
                            <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 h-6 rounded-full transition-all duration-700 flex items-center justify-end px-3"
                                 style="width: {{ min($levelProgress, 100) }}%">
                                @if($levelProgress > 15)
                                    <span class="text-xs text-white font-bold drop-shadow">{{ number_format($levelProgress, 0) }}%</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Статистика -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-blue-100 font-medium mb-1">Открыто достижений</div>
                                    <div class="text-3xl font-bold">
                                        {{ auth()->user()->achievements->count() }}<span class="text-xl text-blue-200"> / {{ $achievements->count() }}</span>
                                    </div>
                                </div>
                                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-orange-500 to-red-500 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-orange-100 font-medium mb-1">Дней подряд</div>
                                    <div class="text-3xl font-bold">
                                        {{ auth()->user()->streak_days }}
                                    </div>
                                </div>
                                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-purple-500 to-indigo-600 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-purple-100 font-medium mb-1">Общий прогресс</div>
                                    <div class="text-3xl font-bold">
                                        {{ number_format((auth()->user()->achievements->count() / max($achievements->count(), 1)) * 100, 1) }}%
                                    </div>
                                </div>
                                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Список достижений по категориям -->
            @foreach($achievementsByCategory as $category => $categoryAchievements)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden transition-colors duration-300">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                            @switch($category)
                                @case('tasks')
                                    <div class="bg-blue-100 rounded-lg p-2">
                                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span>Задачи</span>
                                    @break
                                @case('productivity')
                                    <div class="bg-yellow-100 rounded-lg p-2">
                                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span>Продуктивность</span>
                                    @break
                                @case('social')
                                    <div class="bg-purple-100 rounded-lg p-2">
                                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                        </svg>
                                    </div>
                                    <span>Социальные</span>
                                    @break
                                @case('streak')
                                    <div class="bg-orange-100 rounded-lg p-2">
                                        <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span>Серии</span>
                                    @break
                                @case('special')
                                    <div class="bg-pink-100 rounded-lg p-2">
                                        <svg class="w-6 h-6 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                    <span>Особые</span>
                                    @break
                                @default
                                    <div class="bg-gray-100 rounded-lg p-2">
                                        <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span>{{ ucfirst($category) }}</span>
                            @endswitch
                        </h3>
                    </div>
                    <div class="p-6">

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
