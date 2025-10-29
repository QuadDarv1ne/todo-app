@props(['taskId' => null])

<div class="bulk-notion-reminder-button">
    <button type="button" 
            class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium bulk-notion-reminder-btn"
            data-task-id="{{ $taskId }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
        </svg>
        Notion напоминание
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle bulk notion reminder
        document.querySelectorAll('.bulk-notion-reminder-btn').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                
                // Handle notion reminder logic here
                console.log('Setting notion reminder for task:', taskId);
                
                // Example implementation:
                // Open notion reminder settings modal
            });
        });
    });
</script>