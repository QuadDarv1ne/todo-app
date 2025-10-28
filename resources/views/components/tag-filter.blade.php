@props(['tags', 'selectedTags' => []])

<div class="tag-filter">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Фильтр по тегам</h3>
        @if(count($selectedTags) > 0)
            <button class="text-sm text-indigo-600 hover:text-indigo-800 transition-colors duration-200 clear-tags">
                Очистить все
            </button>
        @endif
    </div>
    
    <div class="flex flex-wrap gap-2">
        @foreach($tags as $tag)
            @php
                $isSelected = in_array($tag->id, $selectedTags);
                $bgColor = $isSelected ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800';
                $hoverColor = $isSelected ? 'hover:bg-indigo-200' : 'hover:bg-gray-200';
            @endphp
            <button 
                type="button"
                class="tag-button px-3 py-1.5 text-sm font-medium rounded-full {{ $bgColor }} {{ $hoverColor }} transition-colors duration-200 flex items-center gap-1"
                data-tag-id="{{ $tag->id }}"
            >
                {{ $tag->name }}
                @if($isSelected)
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                @endif
            </button>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle tag selection
        document.querySelectorAll('.tag-button').forEach(button => {
            button.addEventListener('click', function() {
                const tagId = this.getAttribute('data-tag-id');
                // Handle tag selection logic here
                console.log('Tag selected:', tagId);
            });
        });
        
        // Handle clear all tags
        document.querySelector('.clear-tags')?.addEventListener('click', function() {
            // Handle clear all tags logic here
            console.log('Clear all tags');
        });
    });
</script>