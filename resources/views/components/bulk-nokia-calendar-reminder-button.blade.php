@props(['taskId' => null])

<div class="bulk-nokia-calendar-reminder-button">
    <button type="button" 
            class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium bulk-nokia-calendar-reminder-btn"
            data-task-id="{{ $taskId }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Nokia Calendar
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle bulk nokia calendar reminder
        document.querySelectorAll('.bulk-nokia-calendar-reminder-btn').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                
                // Handle nokia calendar reminder logic here
                console.log('Setting nokia calendar reminder for task:', taskId);
                
                // Example implementation:
                // Open nokia calendar reminder settings modal
            });
        });
    });
</script>