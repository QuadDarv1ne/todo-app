@props(['icon', 'label' => null, 'type' => 'button', 'size' => 'md'])

@php
    $sizeClasses = [
        'sm' => 'p-1.5',
        'md' => 'p-2',
        'lg' => 'p-3',
    ];
    
    $iconSizes = [
        'sm' => 'h-4 w-4',
        'md' => 'h-5 w-5',
        'lg' => 'h-6 w-6',
    ];
@endphp

<button 
    type="{{ $type }}"
    {{ $attributes->merge(['class' => "inline-flex items-center justify-center rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors duration-200 {$sizeClasses[$size]}"]) }}
>
    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconSizes[$size] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        {!! $icon !!}
    </svg>
    @if($label)
        <span class="ml-2 text-sm font-medium">{{ $label }}</span>
    @endif
</button>