@props(['currentFilter' => 'all', 'searchQuery' => ''])

<div class="task-filters bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">
        <!-- Search -->
        <div class="flex-1 max-w-2xl">
            <form method="GET" action="{{ route('tasks.index') }}" class="relative">
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
                    <a href="{{ route('tasks.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
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
                <a href="{{ route('tasks.index', array_merge(request()->except('filter', 'page'), ['filter' => $key])) }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $currentFilter === $key ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
</div>