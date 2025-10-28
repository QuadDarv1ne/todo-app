@props(['categories', 'selected' => null, 'onSelect' => null])

<div class="category-list">
    <label class="block text-sm font-medium text-gray-700 mb-2">Категория</label>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
        @foreach($categories as $category)
            @php
                $isSelected = $selected && $selected->id === $category->id;
                $bgColor = $isSelected ? 'bg-indigo-100 text-indigo-800 border-indigo-300' : 'bg-white text-gray-700 border-gray-300';
                $hoverColor = $isSelected ? 'hover:bg-indigo-200' : 'hover:bg-gray-50';
            @endphp
            <button 
                type="button"
                class="flex flex-col items-center justify-center p-3 rounded-lg border {{ $bgColor }} {{ $hoverColor }} transition-colors duration-200"
                data-category-id="{{ $category->id }}"
                onclick="{{ $onSelect ? $onSelect . '(' . $category->id . ')' : '' }}"
            >
                @if($category->icon)
                    <div class="mb-2 text-lg">
                        {!! $category->icon !!}
                    </div>
                @endif
                <span class="text-sm font-medium text-center">{{ $category->name }}</span>
                @if($category->task_count !== null)
                    <span class="text-xs text-gray-500 mt-1">{{ $category->task_count }} задач</span>
                @endif
            </button>
        @endforeach
    </div>
</div>