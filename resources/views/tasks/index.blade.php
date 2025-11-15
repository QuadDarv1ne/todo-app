@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('task-form');
    
    // Add task
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        const dueDate = document.getElementById('due_date').value;
        const priority = document.getElementById('priority').value;
        const enableReminders = document.getElementById('enable-reminders').checked;
        
        if (!title) return;

        try {
            const res = await fetch('{{ route("tasks.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ 
                    title, 
                    description: description || null,
                    due_date: dueDate || null,
                    priority: priority,
                    enable_reminders: enableReminders
                })
            });

            if (res.ok) {
                const data = await res.json();
                form.reset();
                window.location.reload();
            } else {
                const error = await res.json();
                alert(error.message || 'Не удалось добавить задачу');
            }
        } catch (error) {
            console.error('Ошибка:', error);
            alert('Не удалось добавить задачу');
        }
    });

    // Edit task modal
    const editModal = document.getElementById('editTaskModal');
    const editForm = document.getElementById('editTaskForm');
    const cancelEdit = document.getElementById('cancelEdit');
    
    // Open edit modal
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.edit-task');
        if (!btn) return;
        
        const taskId = btn.dataset.id;
        
        try {
            // Fetch task data
            const res = await fetch(`/tasks/${taskId}`);
            if (!res.ok) throw new Error('Не удалось загрузить задачу');
            
            const data = await res.json();
            const task = data.task;
            
            // Populate form
            document.getElementById('edit-title').value = task.title;
            document.getElementById('edit-description').value = task.description || '';
            document.getElementById('edit-due_date').value = task.due_date || '';
            document.getElementById('edit-priority').value = task.priority || 'medium';
            
            // Store task ID in form
            editForm.dataset.taskId = taskId;
            
            // Show modal
            editModal.classList.remove('hidden');
        } catch (error) {
            console.error('Ошибка:', error);
            alert('Не удалось загрузить задачу');
        }
    });
    
    // Close edit modal
    cancelEdit.addEventListener('click', () => {
        editModal.classList.add('hidden');
    });
    
    // Update task
    editForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const taskId = editForm.dataset.taskId;
        const title = document.getElementById('edit-title').value.trim();
        const description = document.getElementById('edit-description').value.trim();
        const dueDate = document.getElementById('edit-due_date').value;
        const priority = document.getElementById('edit-priority').value;
        
        if (!title) return;

        try {
            const res = await fetch(`/tasks/${taskId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ 
                    title, 
                    description: description || null,
                    due_date: dueDate || null,
                    priority: priority
                })
            });

            if (res.ok) {
                const data = await res.json();
                editModal.classList.add('hidden');
                window.location.reload();
            } else {
                const error = await res.json();
                alert(error.message || 'Не удалось обновить задачу');
            }
        } catch (error) {
            console.error('Ошибка:', error);
            alert('Не удалось обновить задачу');
        }
    });
    
    // Delete task
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.delete-task');
        if (!btn) return;
        
        const taskId = btn.dataset.id;
        const taskTitle = btn.dataset.title;
        
        if (!confirm(`Вы уверены, что хотите удалить задачу "${taskTitle}"?`)) return;

        try {
            const res = await fetch(`/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (res.ok) {
                window.location.reload();
            } else {
                const error = await res.json();
                alert(error.message || 'Не удалось удалить задачу');
            }
        } catch (error) {
            console.error('Ошибка:', error);
            alert('Не удалось удалить задачу');
        }
    });
    
    // Toggle task completion
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.toggle-completion');
        if (!btn) return;
        
        const taskId = btn.dataset.id;
        const isCompleted = btn.dataset.completed === 'true';
        const newStatus = !isCompleted;
        
        try {
            const res = await fetch(`/tasks/${taskId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ 
                    completed: newStatus
                })
            });

            if (res.ok) {
                window.location.reload();
            } else {
                const error = await res.json();
                alert(error.message || 'Не удалось обновить статус задачи');
            }
        } catch (error) {
            console.error('Ошибка:', error);
            alert('Не удалось обновить статус задачи');
        }
    });
    
    // Drag and drop reordering
    const taskList = document.getElementById('task-list');
    if (taskList) {
        new Sortable(taskList, {
            animation: 150,
            ghostClass: 'bg-blue-50',
            onEnd: async function (evt) {
                const tasks = [];
                const taskElements = taskList.querySelectorAll('.task-card');
                
                taskElements.forEach((el, index) => {
                    tasks.push({
                        id: el.dataset.taskId,
                        order: index
                    });
                });
                
                try {
                    const res = await fetch('{{ route("tasks.reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ tasks })
                    });
                    
                    if (!res.ok) {
                        const error = await res.json();
                        alert(error.message || 'Не удалось изменить порядок задач');
                        window.location.reload();
                    }
                } catch (error) {
                    console.error('Ошибка:', error);
                    alert('Не удалось изменить порядок задач');
                    window.location.reload();
                }
            }
        });
    }
});
</script>
@endpush