@props(['sortBy' => 'created_at', 'sortDirection' => 'desc'])

@php
    $sortOptions = [
        'created_at|desc' => 'Новые первыми',
        'created_at|asc' => 'Старые первыми',
        'title|asc' => 'Название (А-Я)',
        'title|desc' => 'Название (Я-А)',
        'completed|desc' => 'Сначала завершённые',
        'completed|asc' => 'Сначала активные',
        'priority|desc' => 'Высокий приоритет',
        'priority|asc' => 'Низкий приоритет',
    ];
@endphp

<div class="sort-control relative" x-data="{ open: false }">
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