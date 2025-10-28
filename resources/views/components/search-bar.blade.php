@props(['searchQuery' => '', 'placeholder' => 'Поиск...'])

<div class="search-bar">
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
            placeholder="{{ $placeholder }}"
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
    
    @if($searchQuery)
        <div class="mt-2 text-sm text-gray-600">
            Результаты поиска для: <span class="font-medium">"{{ $searchQuery }}"</span>
        </div>
    @endif
</div>