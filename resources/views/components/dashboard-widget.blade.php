@props(['title', 'description' => null, 'action' => null, 'actionText' => null, 'actionUrl' => null])

<div class="dashboard-widget bg-white rounded-xl shadow-sm p-6 border border-gray-200">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-semibold text-gray-900">{{ $title }}</h3>
            @if($description)
                <p class="text-gray-600 mt-1">{{ $description }}</p>
            @endif
        </div>
        @if($action)
            <button class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                {!! $action !!}
            </button>
        @endif
    </div>
    
    <div class="widget-content">
        {{ $slot }}
    </div>
    
    @if($actionText && $actionUrl)
        <div class="mt-6 pt-6 border-t border-gray-200">
            <a href="{{ $actionUrl }}" 
               class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200">
                {{ $actionText }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    @endif
</div>