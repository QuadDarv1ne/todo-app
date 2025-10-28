@props(['filters' => [], 'currentFilter' => 'all', 'searchQuery' => '', 'sortBy' => 'created_at', 'sortDirection' => 'desc'])

<div class="task-filter-panel bg-white rounded-xl shadow-sm p-6 border border-gray-200">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <!-- Search -->
        <div class="flex-1 max-w-2xl">
            <form method="GET" action="{{ request()->url() }}" class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    name="search"
                    value="{{ $searchQuery }}"
                    placeholder="Поиск задач..."
                    class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-base shadow-sm"
                >
                @if($searchQuery)
                    <a href="{{ request()->url() }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                @endif
            </form>
        </div>
        
        <!-- Filters and Sort -->
        <div class="flex flex-wrap gap-3">
            <!-- Status Filter -->
            @php
                $statusFilters = [
                    'all' => 'Все задачи',
                    'pending' => 'Активные',
                    'completed' => 'Завершённые'
                ];
            @endphp
            
            @foreach($statusFilters as $key => $label)
                <a href="{{ request()->fullUrlWithQuery(['filter' => $key, 'page' => 1]) }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $currentFilter === $key ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $label }}
                </a>
            @endforeach
            
            <!-- Sort Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-200 text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                    </svg>
                    Сортировка
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                
                <div x-show="open" @click.away="open = false" 
                     class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                    @php
                        $sortOptions = [
                            'created_at|desc' => 'Новые первыми',
                            'created_at|asc' => 'Старые первыми',
                            'title|asc' => 'Название (А-Я)',
                            'title|desc' => 'Название (Я-А)',
                            'completed|desc' => 'Сначала завершённые',
                            'completed|asc' => 'Сначала активные'
                        ];
                    @endphp
                    
                    @foreach($sortOptions as $value => $label)
                        @php
                            [$field, $direction] = explode('|', $value);
                        @endphp
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => $field, 'sort_direction' => $direction, 'page' => 1]) }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ ($sortBy === $field && $sortDirection === $direction) ? 'bg-gray-100 font-medium' : '' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional Filters -->
    @if(!empty($filters))
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="flex flex-wrap gap-3">
                @foreach($filters as $filter)
                    <button class="px-3 py-1.5 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors duration-200">
                        {{ $filter['label'] }}
                        <span class="ml-1 text-gray-500">×</span>
                    </button>
                @endforeach
                @if(count($filters) > 1)
                    <button class="px-3 py-1.5 text-sm font-medium rounded-full text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
                        Очистить все
                    </button>
                @endif
            </div>
        </div>
    @endif
</div>