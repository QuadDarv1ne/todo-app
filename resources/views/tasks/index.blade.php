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
        document.getElementById('edit-completed').checked = task.completed;
        document.getElementById('edit-reminders').checked = task.reminders_enabled;
        
        // Store task ID in form
        editForm.dataset.taskId = taskId;
        
        // Show modal
        editModal.classList.remove('hidden');
    } catch (error) {
        console.error('Ошибка:', error);
        alert('Не удалось загрузить задачу');
    }
});

// Update task
editForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const taskId = editForm.dataset.taskId;
    const title = document.getElementById('edit-title').value.trim();
    const description = document.getElementById('edit-description').value.trim();
    const dueDate = document.getElementById('edit-due_date').value;
    const priority = document.getElementById('edit-priority').value;
    const completed = document.getElementById('edit-completed').checked;
    const remindersEnabled = document.getElementById('edit-reminders').checked;
    
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
                priority: priority,
                completed: completed,
                reminders_enabled: remindersEnabled
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