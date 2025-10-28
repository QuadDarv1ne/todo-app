@props(['title', 'value', 'description', 'color' => 'blue'])

<div class="stats-card bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 overflow-hidden">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $value }}</p>
            @if($description)
                <p class="text-xs text-gray-500 mt-2">{{ $description }}</p>
            @endif
        </div>
        
        @if(trim($slot))
            <div class="p-3 rounded-lg bg-{{ $color }}-100 text-{{ $color }}-600">
                <div class="h-8 w-8">
                    {!! $slot !!}
                </div>
            </div>
        @endif
    </div>
</div>