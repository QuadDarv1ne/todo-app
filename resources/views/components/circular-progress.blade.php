@props(['percentage', 'size' => 'md', 'label' => null])

@php
    $sizes = [
        'sm' => ['container' => 'w-24 h-24', 'text' => 'text-lg'],
        'md' => ['container' => 'w-32 h-32', 'text' => 'text-xl'],
        'lg' => ['container' => 'w-40 h-40', 'text' => 'text-2xl'],
    ];
    
    $containerSize = $sizes[$size]['container'];
    $textSize = $sizes[$size]['text'];
    
    // Calculate the stroke-dasharray and stroke-dashoffset for the progress
    $radius = $size === 'sm' ? 36 : ($size === 'md' ? 48 : 60);
    $circumference = 2 * pi() * $radius;
    $strokeDashoffset = $circumference - ($percentage / 100) * $circumference;
@endphp

<div class="circular-progress flex flex-col items-center">
    @if($label)
        <div class="mb-3 text-sm font-medium text-gray-700">{{ $label }}</div>
    @endif
    
    <div class="{{ $containerSize }} relative">
        <svg class="w-full h-full" viewBox="0 0 120 120">
            <!-- Background circle -->
            <circle
                cx="60"
                cy="60"
                r="{{ $radius }}"
                fill="none"
                stroke="#e5e7eb"
                stroke-width="10"
            />
            
            <!-- Progress circle -->
            <circle
                cx="60"
                cy="60"
                r="{{ $radius }}"
                fill="none"
                stroke="#6366f1"
                stroke-width="10"
                stroke-linecap="round"
                stroke-dasharray="{{ $circumference }}"
                stroke-dashoffset="{{ $strokeDashoffset }}"
                transform="rotate(-90 60 60)"
                class="transition-all duration-1000 ease-out"
            />
        </svg>
        
        <!-- Percentage text -->
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="{{ $textSize }} font-bold text-gray-900">{{ round($percentage) }}%</span>
        </div>
    </div>
</div>