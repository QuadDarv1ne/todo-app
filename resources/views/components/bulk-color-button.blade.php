@props(['taskId' => null])

<div class="bulk-color-button">
    <button type="button" 
            class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium bulk-color-btn"
            data-task-id="{{ $taskId }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
        </svg>
        Цвет
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle bulk color
        document.querySelectorAll('.bulk-color-btn').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                
                // Handle color logic here
                console.log('Setting color for task:', taskId);
                
                // Example implementation:
                // Open color selection modal
            });
        });
    });
</script>