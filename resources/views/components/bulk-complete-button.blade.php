@props(['taskId' => null])

<div class="bulk-complete-button">
    <button type="button" 
            class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm font-medium bulk-complete-btn"
            data-task-id="{{ $taskId }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Завершить
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle bulk complete
        document.querySelectorAll('.bulk-complete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                
                // Handle complete logic here
                console.log('Completing task:', taskId);
                
                // Example implementation:
                // fetch(`/tasks/${taskId}`, {
                //     method: 'PATCH',
                //     headers: {
                //         'Content-Type': 'application/json',
                //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                //     },
                //     body: JSON.stringify({ completed: true })
                // }).then(response => {
                //     if (response.ok) {
                //         // Update UI
                //         const taskItem = this.closest('.task-item');
                //         taskItem.querySelector('.task-title').classList.add('line-through', 'text-gray-400');
                //         taskItem.querySelector('.task-title').classList.remove('text-gray-900');
                //     } else {
                //         throw new Error('Complete failed');
                //     }
                // }).catch(error => {
                //     console.error('Complete error:', error);
                //     alert('Ошибка при завершении задачи');
                // });
            });
        });
    });
</script>