@props(['tasks'])

<div class="drag-drop-task-list">
    <div class="sortable-tasks space-y-5" id="task-list">
        @foreach($tasks as $task)
            <div class="task-item" data-task-id="{{ $task->id }}" draggable="true">
                <x-task-card :task="$task" />
            </div>
        @endforeach
    </div>
</div>

<style>
    .task-item.dragging {
        opacity: 0.5;
        transform: scale(0.98);
    }
    
    .task-item.drag-over {
        border-top: 2px solid #6366f1;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const taskList = document.getElementById('task-list');
        const taskItems = taskList.querySelectorAll('.task-item');
        let draggedItem = null;
        
        taskItems.forEach(item => {
            // Make item draggable
            item.setAttribute('draggable', true);
            
            // Drag start event
            item.addEventListener('dragstart', function() {
                draggedItem = this;
                setTimeout(() => {
                    this.classList.add('dragging');
                }, 0);
            });
            
            // Drag end event
            item.addEventListener('dragend', function() {
                this.classList.remove('dragging');
                draggedItem = null;
                
                // Save new order
                saveTaskOrder();
            });
            
            // Drag over event
            item.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('drag-over');
            });
            
            // Drag leave event
            item.addEventListener('dragleave', function() {
                this.classList.remove('drag-over');
            });
            
            // Drop event
            item.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('drag-over');
                
                if (draggedItem !== this) {
                    const allItems = Array.from(taskList.children);
                    const thisIndex = allItems.indexOf(this);
                    const draggedIndex = allItems.indexOf(draggedItem);
                    
                    if (draggedIndex < thisIndex) {
                        taskList.insertBefore(draggedItem, this.nextSibling);
                    } else {
                        taskList.insertBefore(draggedItem, this);
                    }
                }
            });
        });
        
        // Save task order to server
        function saveTaskOrder() {
            const taskIds = Array.from(taskList.children).map(item => 
                item.getAttribute('data-task-id')
            );
            
            // Send to server
            fetch('/tasks/reorder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ task_ids: taskIds })
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Failed to save task order');
                }
                return response.json();
            }).then(data => {
                console.log('Task order saved:', data);
            }).catch(error => {
                console.error('Error saving task order:', error);
                alert('Ошибка при сохранении порядка задач');
            });
        }
    });
</script>