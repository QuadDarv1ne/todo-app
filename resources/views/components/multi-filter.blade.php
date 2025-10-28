@props(['filters' => [], 'activeFilters' => []])

<div class="multi-filter bg-white rounded-xl shadow-sm p-6 border border-gray-200">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-semibold text-gray-900">Фильтры</h3>
        @if(count($activeFilters) > 0)
            <button class="text-sm text-indigo-600 hover:text-indigo-800 transition-colors duration-200 clear-filters">
                Очистить все фильтры
            </button>
        @endif
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($filters as $filter)
            <div class="filter-group">
                <h4 class="text-sm font-medium text-gray-700 mb-3">{{ $filter['title'] }}</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach($filter['options'] as $option)
                        @php
                            $isActive = isset($activeFilters[$filter['key']]) && 
                                       (is_array($activeFilters[$filter['key']]) 
                                           ? in_array($option['value'], $activeFilters[$filter['key']]) 
                                           : $activeFilters[$filter['key']] === $option['value']);
                            $bgColor = $isActive ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800';
                            $hoverColor = $isActive ? 'hover:bg-indigo-200' : 'hover:bg-gray-200';
                        @endphp
                        <button 
                            type="button"
                            class="filter-option px-3 py-1.5 text-sm font-medium rounded-full {{ $bgColor }} {{ $hoverColor }} transition-colors duration-200"
                            data-filter="{{ $filter['key'] }}"
                            data-value="{{ $option['value'] }}">
                            {{ $option['label'] }}
                            @if($isActive)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    
    @if(count($activeFilters) > 0)
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="flex flex-wrap gap-2">
                @foreach($activeFilters as $key => $values)
                    @php
                        $filter = collect($filters)->firstWhere('key', $key);
                    @endphp
                    @if($filter)
                        @foreach(is_array($values) ? $values : [$values] as $value)
                            @php
                                $option = collect($filter['options'])->firstWhere('value', $value);
                            @endphp
                            @if($option)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                    {{ $filter['title'] }}: {{ $option['label'] }}
                                    <button type="button" class="ml-2 remove-filter" data-filter="{{ $key }}" data-value="{{ $value }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle filter selection
        document.querySelectorAll('.filter-option').forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                const value = this.getAttribute('data-value');
                // Handle filter selection logic here
                console.log('Filter selected:', filter, value);
            });
        });
        
        // Handle filter removal
        document.querySelectorAll('.remove-filter').forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                const value = this.getAttribute('data-value');
                // Handle filter removal logic here
                console.log('Filter removed:', filter, value);
            });
        });
        
        // Handle clear all filters
        document.querySelector('.clear-filters')?.addEventListener('click', function() {
            // Handle clear all filters logic here
            console.log('Clear all filters');
        });
    });
</script>