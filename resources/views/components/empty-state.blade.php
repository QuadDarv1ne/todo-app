@props(['title', 'description', 'icon', 'actionText' => null, 'actionUrl' => null])

<div class="empty-state text-center py-16">
    @if($icon)
        <div class="mx-auto h-16 w-16 text-gray-400 mb-6">
            {!! $icon !!}
        </div>
    @endif
    
    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $title }}</h3>
    <p class="text-gray-600 max-w-md mx-auto">
        {{ $description }}
    </p>
    
    @if($actionText && $actionUrl)
        <div class="mt-8">
            <a href="{{ $actionUrl }}" 
               class="inline-flex items-center px-5 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                {{ $actionText }}
            </a>
        </div>
    @endif
</div>