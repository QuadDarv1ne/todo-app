@props(['selectedPriority' => null])

@php
    $priorities = [
        'low' => ['label' => 'Низкий', 'color' => 'bg-green-100 text-green-800'],
        'medium' => ['label' => 'Средний', 'color' => 'bg-yellow-100 text-yellow-800'],
        'high' => ['label' => 'Высокий', 'color' => 'bg-red-100 text-red-800'],
    ];
@endphp

<div class="priority-filter">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Фильтр по приоритету</h3>
    
    <div class="flex flex-wrap gap-2">
        <button 
            type="button"
            class="priority-button px-4 py-2 text-sm font-medium rounded-lg {{ is_null($selectedPriority) ? 'bg-indigo-100 text-indigo-800 border-indigo-300' : 'bg-white text-gray-700 border-gray-300' }} border transition-colors duration-200 flex items-center gap-2"
            data-priority="">
            Все приоритеты
        </button>
        
        @foreach($priorities as $value => $priority)
            <button 
                type="button"
                class="priority-button px-4 py-2 text-sm font-medium rounded-lg {{ $selectedPriority === $value ? $priority['color'] . ' border-' . str_replace('bg-', '', str_replace('100', '300', $priority['color'])) : 'bg-white text-gray-700 border-gray-300' }} border transition-colors duration-200 flex items-center gap-2"
                data-priority="{{ $value }}">
                <span class="w-3 h-3 rounded-full {{ str_replace('text-', 'bg-', str_replace('800', '500', $priority['color'])) }}"></span>
                {{ $priority['label'] }}
            </button>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle priority selection
        document.querySelectorAll('.priority-button').forEach(button => {
            button.addEventListener('click', function() {
                const priority = this.getAttribute('data-priority');
                // Handle priority selection logic here
                console.log('Priority selected:', priority);
            });
        });
    });
</script>