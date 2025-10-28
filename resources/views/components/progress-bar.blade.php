@props(['percentage', 'label' => null, 'size' => 'md'])

<div class="progress-bar">
    @if($label)
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
            <span class="text-sm font-bold text-indigo-600">{{ round($percentage) }}%</span>
        </div>
    @endif
    
    @php
        $height = match($size) {
            'sm' => 'h-2',
            'lg' => 'h-4',
            default => 'h-3',
        };
    @endphp
    
    <div class="w-full bg-gray-200 rounded-full overflow-hidden {{ $height }}">
        <div 
            class="h-full bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full transition-all duration-500 ease-out"
            style="width: {{ $percentage }}%"
        ></div>
    </div>
    
    @if($label)
        <div class="mt-2 text-xs text-gray-500">
            {{ $slot }}
        </div>
    @endif
</div>