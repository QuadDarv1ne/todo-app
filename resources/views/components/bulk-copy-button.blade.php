@props(['taskId' => null])

<div class="bulk-copy-button">
    <button type="button" 
            class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium bulk-copy-btn"
            data-task-id="{{ $taskId }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
        </svg>
        Копировать
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle bulk copy
        document.querySelectorAll('.bulk-copy-btn').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                
                // Handle copy logic here
                console.log('Copying task:', taskId);
                
                // Example implementation:
                // fetch(`/tasks/${taskId}/copy`, {
                //     method: 'POST',
                //     headers: {
                //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                //     }
                // }).then(response => {
                //     if (response.ok) {
                //         return response.json();
                //     } else {
                //         throw new Error('Copy failed');
                //     }
                // }).then(data => {
                //     // Add new task to UI
                //     console.log('Task copied:', data);
                // }).catch(error => {
                //     console.error('Copy error:', error);
                //     alert('Ошибка при копировании задачи');
                // });
            });
        });
    });
</script>