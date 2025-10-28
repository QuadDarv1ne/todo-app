@props(['percentage', 'label' => null, 'size' => 'md'])

<div class="progress-bar">
    @if($label)
        <div class="flex justify-between items-center mb-3">
            <span class="text-base font-semibold text-gray-700">{{ $label }}</span>
            <span class="text-xl font-bold text-indigo-600">{{ round($percentage) }}%</span>
        </div>
    @endif
    
    @php
        $height = match($size) {
            'sm' => 'h-2.5',
            'lg' => 'h-5',
            default => 'h-4',
        };
    @endphp
    
    <div class="w-full bg-gray-200 rounded-full overflow-hidden {{ $height }}">
        <div 
            class="h-full bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full transition-all duration-1000 ease-out shadow-sm"
            style="width: {{ $percentage }}%"
        ></div>
    </div>
    
    @if($label && trim($slot))
        <div class="mt-3 text-sm text-gray-600">
            {{ $slot }}
        </div>
    @endif
</div>