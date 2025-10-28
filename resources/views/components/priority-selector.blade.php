@props(['selected' => null, 'name' => 'priority'])

@php
    $priorities = [
        'low' => ['label' => 'Низкий', 'color' => 'bg-green-100 text-green-800'],
        'medium' => ['label' => 'Средний', 'color' => 'bg-yellow-100 text-yellow-800'],
        'high' => ['label' => 'Высокий', 'color' => 'bg-red-100 text-red-800'],
    ];
@endphp

<div class="priority-selector">
    <label class="block text-sm font-medium text-gray-700 mb-2">Приоритет</label>
    <div class="flex gap-2">
        @foreach($priorities as $value => $priority)
            <button 
                type="button"
                class="flex-1 px-3 py-2 text-sm font-medium rounded-lg border transition-colors duration-200 {{ $selected === $value ? $priority['color'] . ' border-' . str_replace('bg-', 'border-', str_replace('100', '300', $priority['color'])) : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50' }}"
                data-value="{{ $value }}"
                onclick="document.getElementById('{{ $name }}').value = '{{ $value }}'; this.parentElement.querySelectorAll('button').forEach(btn => btn.classList.remove('bg-green-100', 'text-green-800', 'border-green-300', 'bg-yellow-100', 'text-yellow-800', 'border-yellow-300', 'bg-red-100', 'text-red-800', 'border-red-300', 'border-gray-300')); this.classList.add('{{ str_replace('bg-', 'bg-', str_replace('100', '100', $priority['color'])) }}', '{{ str_replace('text-', 'text-', str_replace('800', '800', $priority['color'])) }}', 'border-' + '{{ str_replace('bg-', '', str_replace('100', '300', $priority['color'])) }}');"
            >
                {{ $priority['label'] }}
            </button>
        @endforeach
    </div>
    <input type="hidden" name="{{ $name }}" id="{{ $name }}" value="{{ $selected }}">
</div>