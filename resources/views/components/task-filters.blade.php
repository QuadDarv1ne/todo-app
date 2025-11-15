@props(['currentFilter' => 'all', 'searchQuery' => '', 'userTags' => []])

<div class="task-filters bg-white rounded-xl shadow-sm border border-gray-200 p-6" x-data="{ showAdvanced: false }">
    <div class="space-y-4">
        <!-- Основные фильтры -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">
            <!-- Search -->
            <div class="flex-1 max-w-2xl">
                <form method="GET" action="{{ route('tasks.index') }}" class="relative">
                    <input type="hidden" name="filter" value="{{ request('filter', 'all') }}">
                    <input type="hidden" name="priority" value="{{ request('priority', '') }}">
                    <input type="hidden" name="tag" value="{{ request('tag', '') }}">
                    <input type="hidden" name="due_date" value="{{ request('due_date', '') }}">
                    
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="search"
                        value="{{ $searchQuery }}"
                        placeholder="Поиск задач по названию или описанию..."
                        class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-base shadow-sm"
                    >
                    @if($searchQuery)
                        <a href="{{ route('tasks.index', request()->except(['search', 'page'])) }}" 
                           class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    @endif
                </form>
            </div>
            
            <!-- Filters -->
            <div class="flex flex-wrap gap-2">
                @php
                    $filters = [
                        'all' => 'Все задачи',
                        'pending' => 'Активные',
                        'completed' => 'Завершённые'
                    ];
                @endphp
                
                @foreach($filters as $key => $label)
                    <a href="{{ route('tasks.index', array_merge(request()->except(['filter', 'page']), ['filter' => $key])) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $currentFilter === $key ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Кнопка расширенных фильтров -->
        <div class="flex items-center justify-between border-t pt-4">
            <button @click="showAdvanced = !showAdvanced" 
                    type="button"
                    class="flex items-center gap-2 text-sm font-medium text-indigo-600 hover:text-indigo-800 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
                <span x-text="showAdvanced ? 'Скрыть расширенные фильтры' : 'Расширенные фильтры'"></span>
            </button>

            @if(request()->hasAny(['priority', 'tag', 'due_date', 'search']))
                <a href="{{ route('tasks.index') }}" 
                   class="text-sm font-medium text-gray-600 hover:text-gray-800 transition">
                    Сбросить все фильтры
                </a>
            @endif
        </div>

        <!-- Расширенные фильтры -->
        <div x-show="showAdvanced" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             class="border-t pt-4">
            <form method="GET" action="{{ route('tasks.index') }}" class="space-y-4">
                <input type="hidden" name="search" value="{{ request('search', '') }}">
                <input type="hidden" name="filter" value="{{ request('filter', 'all') }}">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Фильтр по приоритету -->
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Приоритет</label>
                        <select name="priority" 
                                id="priority" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">Все приоритеты</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>🔴 Высокий</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>🟡 Средний</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>🟢 Низкий</option>
                        </select>
                    </div>

                    <!-- Фильтр по дате -->
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Срок выполнения</label>
                        <select name="due_date" 
                                id="due_date" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">Любой срок</option>
                            <option value="today" {{ request('due_date') == 'today' ? 'selected' : '' }}>📅 Сегодня</option>
                            <option value="tomorrow" {{ request('due_date') == 'tomorrow' ? 'selected' : '' }}>📆 Завтра</option>
                            <option value="week" {{ request('due_date') == 'week' ? 'selected' : '' }}>📊 На этой неделе</option>
                            <option value="overdue" {{ request('due_date') == 'overdue' ? 'selected' : '' }}>⚠️ Просроченные</option>
                        </select>
                    </div>

                    <!-- Фильтр по тегу -->
                    @if($userTags->count() > 0)
                        <div>
                            <label for="tag" class="block text-sm font-medium text-gray-700 mb-2">Тег</label>
                            <select name="tag" 
                                    id="tag" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="">Все теги</option>
                                @foreach($userTags as $userTag)
                                    <option value="{{ $userTag->id }}" {{ request('tag') == $userTag->id ? 'selected' : '' }}>
                                        {{ $userTag->name }} ({{ $userTag->tasks_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>

                <!-- Теги как кнопки -->
                @if($userTags->count() > 0)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Быстрый выбор тега</label>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('tasks.index', array_merge(request()->except(['tag', 'page']))) }}" 
                               class="px-3 py-1.5 rounded-full text-sm font-medium transition {{ !request('tag') ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                Все
                            </a>
                            @foreach($userTags as $userTag)
                                <a href="{{ route('tasks.index', array_merge(request()->except('page'), ['tag' => $userTag->id])) }}" 
                                   class="px-3 py-1.5 rounded-full text-sm font-medium transition inline-flex items-center gap-1.5 shadow-sm"
                                   style="background-color: {{ request('tag') == $userTag->id ? $userTag->color : '#f3f4f6' }}; color: {{ request('tag') == $userTag->id ? '#ffffff' : '#374151' }};">
                                    {{ $userTag->name }}
                                    <span class="text-xs opacity-75 bg-white bg-opacity-20 px-1.5 py-0.5 rounded-full">{{ $userTag->tasks_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Кнопки действий -->
                <div class="flex gap-2 pt-2">
                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-sm">
                        Применить фильтры
                    </button>
                    <a href="{{ route('tasks.index') }}" 
                       class="px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                        Сбросить все
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>