@props(['taskId' => null])

<div class="bulk-delete-button">
    <button type="button" 
            class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium bulk-delete-btn"
            data-task-id="{{ $taskId }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
        Удалить
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle bulk delete
        document.querySelectorAll('.bulk-delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                
                if (confirm('Вы уверены, что хотите удалить эту задачу?')) {
                    // Handle delete logic here
                    console.log('Deleting task:', taskId);
                    
                    // Example implementation:
                    // fetch(`/tasks/${taskId}`, {
                    //     method: 'DELETE',
                    //     headers: {
                    //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    //     }
                    // }).then(response => {
                    //     if (response.ok) {
                    //         // Remove task from UI
                    //         this.closest('.task-item').remove();
                    //     } else {
                    //         throw new Error('Delete failed');
                    //     }
                    // }).catch(error => {
                    //     console.error('Delete error:', error);
                    //     alert('Ошибка при удалении задачи');
                    // });
                }
            });
        });
    });
</script>