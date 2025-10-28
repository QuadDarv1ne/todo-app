@props(['taskId' => null])

<div class="bulk-label-button">
    <button type="button" 
            class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium bulk-label-btn"
            data-task-id="{{ $taskId }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
        </svg>
        Метка
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle bulk label
        document.querySelectorAll('.bulk-label-btn').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                
                // Handle label logic here
                console.log('Setting label for task:', taskId);
                
                // Example implementation:
                // Open label selection modal
            });
        });
    });
</script>