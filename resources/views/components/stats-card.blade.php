@props(['title', 'value', 'description', 'icon', 'color' => 'blue'])

<div class="stats-card bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $value }}</p>
            @if($description)
                <p class="text-xs text-gray-500 mt-1">{{ $description }}</p>
            @endif
        </div>
        
        @if($icon)
            <div class="p-3 rounded-lg bg-{{ $color }}-100 text-{{ $color }}-600">
                {!! $icon !!}
            </div>
        @endif
    </div>
</div>