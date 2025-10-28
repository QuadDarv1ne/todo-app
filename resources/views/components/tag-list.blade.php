@props(['tags', 'title' => 'Теги', 'selected' => []])

<div class="tag-list">
    @if($title)
        <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ $title }}</h3>
    @endif
    
    <div class="flex flex-wrap gap-2">
        @foreach($tags as $tag)
            @php
                $isSelected = in_array($tag['id'], $selected);
                $bgColor = $isSelected ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800';
                $hoverColor = $isSelected ? 'hover:bg-indigo-200' : 'hover:bg-gray-200';
            @endphp
            <button 
                type="button"
                class="px-3 py-1.5 text-sm font-medium rounded-full {{ $bgColor }} {{ $hoverColor }} transition-colors duration-200 flex items-center gap-1"
                data-tag-id="{{ $tag['id'] }}"
            >
                {{ $tag['name'] }}
                @if($isSelected)
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                @endif
            </button>
        @endforeach
    </div>
</div>