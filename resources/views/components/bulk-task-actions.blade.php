@props(['actions' => []])

<div class="bulk-task-actions bg-white rounded-xl shadow-sm p-4 border border-gray-200">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <input type="checkbox" id="select-all" class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500">
            <label for="select-all" class="text-sm font-medium text-gray-700">Выбрать все</label>
            <span class="text-sm text-gray-500" id="selected-count">0 выбрано</span>
        </div>
        
        <div class="flex gap-2">
            @foreach($actions as $action)
                <button type="button" 
                        class="px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors duration-200 flex items-center gap-2 bulk-action-btn"
                        data-action="{{ $action['value'] }}"
                        disabled>
                    @if(isset($action['icon']))
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            {!! $action['icon'] !!}
                        </svg>
                    @endif
                    {{ $action['label'] }}
                </button>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all');
        const taskCheckboxes = document.querySelectorAll('.task-checkbox');
        const selectedCount = document.getElementById('selected-count');
        const bulkActionButtons = document.querySelectorAll('.bulk-action-btn');
        
        // Select all functionality
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            taskCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            updateSelectedCount();
            toggleBulkActions();
        });
        
        // Individual checkbox functionality
        taskCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectedCount();
                toggleBulkActions();
                
                // Update select all checkbox state
                const allChecked = Array.from(taskCheckboxes).every(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
            });
        });
        
        // Update selected count
        function updateSelectedCount() {
            const selected = Array.from(taskCheckboxes).filter(cb => cb.checked).length;
            selectedCount.textContent = selected + ' выбрано';
        }
        
        // Toggle bulk action buttons
        function toggleBulkActions() {
            const hasSelection = Array.from(taskCheckboxes).some(cb => cb.checked);
            bulkActionButtons.forEach(button => {
                button.disabled = !hasSelection;
            });
        }
        
        // Bulk action buttons
        bulkActionButtons.forEach(button => {
            button.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                const selectedTasks = Array.from(taskCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.getAttribute('data-task-id'));
                
                if (selectedTasks.length === 0) return;
                
                // Handle bulk action
                handleBulkAction(action, selectedTasks);
            });
        });
        
        // Handle bulk action
        function handleBulkAction(action, taskIds) {
            // This would be implemented based on your specific needs
            console.log('Bulk action:', action, 'Tasks:', taskIds);
            
            // Example implementation:
            switch(action) {
                case 'complete':
                    // Mark tasks as complete
                    break;
                case 'delete':
                    if (confirm('Удалить выбранные задачи?')) {
                        // Delete tasks
                    }
                    break;
                case 'export':
                    // Export tasks
                    break;
            }
        }
    });
</script>