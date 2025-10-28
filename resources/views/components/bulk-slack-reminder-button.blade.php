@props(['taskId' => null])

<div class="bulk-slack-reminder-button">
    <button type="button" 
            class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium bulk-slack-reminder-btn"
            data-task-id="{{ $taskId }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h.01M15 16h.01M19 16h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Slack напоминание
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle bulk slack reminder
        document.querySelectorAll('.bulk-slack-reminder-btn').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                
                // Handle slack reminder logic here
                console.log('Setting slack reminder for task:', taskId);
                
                // Example implementation:
                // Open slack reminder settings modal
            });
        });
    });
</script>