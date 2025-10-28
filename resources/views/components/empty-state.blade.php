@props(['title', 'description', 'icon', 'actionText' => null, 'actionUrl' => null])

<div class="text-center py-12">
    @if($icon)
        <div class="mx-auto h-12 w-12 text-gray-400">
            {!! $icon !!}
        </div>
    @endif
    
    <h3 class="mt-2 text-sm font-medium text-gray-900">{{ $title }}</h3>
    <p class="mt-1 text-sm text-gray-500">
        {{ $description }}
    </p>
    
    @if($actionText && $actionUrl)
        <div class="mt-6">
            <a href="{{ $actionUrl }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ $actionText }}
            </a>
        </div>
    @endif
</div>