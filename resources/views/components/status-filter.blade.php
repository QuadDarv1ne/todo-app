@props(['selectedStatus' => 'all'])

@php
    $statuses = [
        'all' => 'Все задачи',
        'pending' => 'Активные',
        'completed' => 'Завершённые',
        'overdue' => 'Просроченные',
    ];
@endphp

<div class="status-filter">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Фильтр по статусу</h3>
    
    <div class="flex flex-wrap gap-2">
        @foreach($statuses as $value => $label)
            <button 
                type="button"
                class="status-button px-4 py-2 text-sm font-medium rounded-lg {{ $selectedStatus === $value ? 'bg-indigo-100 text-indigo-800 border-indigo-300' : 'bg-white text-gray-700 border-gray-300' }} border transition-colors duration-200"
                data-status="{{ $value }}">
                {{ $label }}
            </button>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle status selection
        document.querySelectorAll('.status-button').forEach(button => {
            button.addEventListener('click', function() {
                const status = this.getAttribute('data-status');
                // Handle status selection logic here
                console.log('Status selected:', status);
            });
        });
    });
</script>