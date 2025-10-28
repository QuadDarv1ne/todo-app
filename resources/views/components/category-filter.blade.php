@props(['categories', 'selectedCategory' => null])

<div class="category-filter">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Фильтр по категории</h3>
    
    <div class="flex flex-wrap gap-2">
        <button 
            type="button"
            class="category-button px-4 py-2 text-sm font-medium rounded-lg {{ is_null($selectedCategory) ? 'bg-indigo-100 text-indigo-800 border-indigo-300' : 'bg-white text-gray-700 border-gray-300' }} border transition-colors duration-200"
            data-category="">
            Все категории
        </button>
        
        @foreach($categories as $category)
            <button 
                type="button"
                class="category-button px-4 py-2 text-sm font-medium rounded-lg {{ $selectedCategory && $selectedCategory->id === $category->id ? 'bg-indigo-100 text-indigo-800 border-indigo-300' : 'bg-white text-gray-700 border-gray-300' }} border transition-colors duration-200 flex items-center gap-2"
                data-category="{{ $category->id }}">
                @if($category->icon)
                    <span class="text-base">{!! $category->icon !!}</span>
                @endif
                {{ $category->name }}
            </button>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle category selection
        document.querySelectorAll('.category-button').forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-category');
                // Handle category selection logic here
                console.log('Category selected:', categoryId);
            });
        });
    });
</script>