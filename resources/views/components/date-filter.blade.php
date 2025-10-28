@props(['selectedDate' => null, 'dateRange' => 'all'])

@php
    $dateRanges = [
        'all' => 'Все даты',
        'today' => 'Сегодня',
        'tomorrow' => 'Завтра',
        'this_week' => 'Эта неделя',
        'next_week' => 'Следующая неделя',
        'this_month' => 'Этот месяц',
        'next_month' => 'Следующий месяц',
    ];
@endphp

<div class="date-filter">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Фильтр по дате</h3>
    
    <div class="flex flex-wrap gap-2">
        @foreach($dateRanges as $value => $label)
            <button 
                type="button"
                class="date-button px-4 py-2 text-sm font-medium rounded-lg {{ $dateRange === $value ? 'bg-indigo-100 text-indigo-800 border-indigo-300' : 'bg-white text-gray-700 border-gray-300' }} border transition-colors duration-200"
                data-range="{{ $value }}">
                {{ $label }}
            </button>
        @endforeach
    </div>
    
    @if($dateRange === 'custom')
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">С</label>
                <input type="date" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition"
                       value="{{ $selectedDate['start'] ?? '' }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">По</label>
                <input type="date" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition"
                       value="{{ $selectedDate['end'] ?? '' }}">
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle date range selection
        document.querySelectorAll('.date-button').forEach(button => {
            button.addEventListener('click', function() {
                const range = this.getAttribute('data-range');
                // Handle date range selection logic here
                console.log('Date range selected:', range);
                
                // If custom range is selected, show date pickers
                if (range === 'custom') {
                    // Show custom date pickers
                }
            });
        });
    });
</script>