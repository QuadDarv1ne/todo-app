// Улучшенные интерактивные функции для компонентов

let currentTaskId = null;

document.addEventListener('DOMContentLoaded', function() {
    // Task completion toggle
    document.querySelectorAll('.task-toggle').forEach(checkbox => {
        checkbox.addEventListener('change', async function() {
            const taskId = this.dataset.id;
            const completed = this.checked;
            
            try {
                const response = await fetch(`/tasks/${taskId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ completed: completed })
                });
                
                if (!response.ok) {
                    throw new Error('Failed to update task');
                }
                
                // Update UI without reload
                const taskCard = this.closest('.task-card');
                const title = taskCard.querySelector('.task-title');
                const statusBadge = taskCard.querySelector('[class*="bg-"][class*="text-"]');
                
                if (completed) {
                    title.classList.add('line-through', 'text-gray-400');
                    title.classList.remove('text-gray-900');
                    if (statusBadge) {
                        statusBadge.classList.remove('bg-blue-100', 'text-blue-800');
                        statusBadge.classList.add('bg-green-100', 'text-green-800');
                        statusBadge.textContent = 'Завершено';
                    }
                } else {
                    title.classList.remove('line-through', 'text-gray-400');
                    title.classList.add('text-gray-900');
                    if (statusBadge) {
                        statusBadge.classList.remove('bg-green-100', 'text-green-800');
                        statusBadge.classList.add('bg-blue-100', 'text-blue-800');
                        statusBadge.textContent = 'Активно';
                    }
                }
            } catch (error) {
                console.error('Error updating task:', error);
                // Revert the checkbox state
                this.checked = !completed;
                alert('Ошибка при обновлении задачи');
            }
        });
    });
    
    // Task deletion
    document.querySelectorAll('.delete-task').forEach(button => {
        button.addEventListener('click', async function() {
            if (!confirm('Удалить задачу?')) return;
            
            const taskId = this.dataset.id;
            
            try {
                const response = await fetch(`/tasks/${taskId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                if (!response.ok) {
                    throw new Error('Failed to delete task');
                }
                
                // Remove task card from UI
                const taskCard = this.closest('.task-card');
                if (taskCard) {
                    taskCard.style.opacity = '0';
                    taskCard.style.transform = 'translateX(-100%)';
                    setTimeout(() => {
                        taskCard.remove();
                    }, 300);
                }
            } catch (error) {
                console.error('Error deleting task:', error);
                alert('Ошибка при удалении задачи');
            }
        });
    });
    
    // Task editing
    document.querySelectorAll('.edit-task').forEach(button => {
        button.addEventListener('click', function() {
            const taskId = this.dataset.id;
            openEditModal(taskId);
        });
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Form enhancements
    const taskForm = document.getElementById('task-form');
    if (taskForm) {
        taskForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const titleInput = document.getElementById('title');
            const descriptionInput = document.getElementById('description');
            
            const title = titleInput.value.trim();
            const description = descriptionInput.value.trim();
            
            if (!title) {
                titleInput.focus();
                return;
            }
            
            try {
                const response = await fetch('/tasks', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ title, description: description || null })
                });
                
                if (!response.ok) {
                    throw new Error('Failed to create task');
                }
                
                const data = await response.json();
                
                // Reset form
                taskForm.reset();
                
                // Show success feedback
                titleInput.classList.add('border-green-500');
                setTimeout(() => {
                    titleInput.classList.remove('border-green-500');
                }, 2000);
                
                // Add new task to the list (optional)
                console.log('Task created:', data.task);
            } catch (error) {
                console.error('Error creating task:', error);
                alert('Ошибка при создании задачи');
            }
        });
    }
    
    // Modal functionality
    const editTaskModal = document.getElementById('editTaskModal');
    const cancelEdit = document.getElementById('cancelEdit');
    const editTaskForm = document.getElementById('editTaskForm');
    
    if (editTaskModal && cancelEdit) {
        cancelEdit.addEventListener('click', closeEditModal);
        
        // Close modal when clicking outside
        editTaskModal.addEventListener('click', function(e) {
            if (e.target === editTaskModal) {
                closeEditModal();
            }
        });
        
        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && editTaskModal.classList.contains('block')) {
                closeEditModal();
            }
        });
    }
    
    if (editTaskForm) {
        editTaskForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!currentTaskId) return;
            
            const formData = new FormData(this);
            const data = {};
            
            for (let [key, value] of formData.entries()) {
                if (key === 'completed') {
                    data[key] = formData.getAll('completed').length > 0;
                } else {
                    data[key] = value;
                }
            }
            
            try {
                const response = await fetch(`/tasks/${currentTaskId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(data)
                });
                
                if (!response.ok) {
                    throw new Error('Failed to update task');
                }
                
                closeEditModal();
                location.reload();
            } catch (error) {
                console.error('Error updating task:', error);
                alert('Ошибка при обновлении задачи');
            }
        });
    }
});

function openEditModal(taskId) {
    currentTaskId = taskId;
    const editTaskModal = document.getElementById('editTaskModal');
    
    if (editTaskModal) {
        editTaskModal.classList.remove('hidden');
        editTaskModal.classList.add('block');
        document.body.classList.add('overflow-hidden');
    }
}

function closeEditModal() {
    const editTaskModal = document.getElementById('editTaskModal');
    
    if (editTaskModal) {
        editTaskModal.classList.remove('block');
        editTaskModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        currentTaskId = null;
    }
}