// Улучшенные интерактивные функции для компонентов

let currentTaskId = null;

document.addEventListener('DOMContentLoaded', function() {
    // Task completion toggle with smooth animation
    document.querySelectorAll('.task-toggle').forEach(checkbox => {
        checkbox.addEventListener('change', async function() {
            const taskId = this.dataset.id;
            const completed = this.checked;
            
            // Add loading state
            this.classList.add('animate-pulse');
            
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
            } finally {
                // Remove loading state
                this.classList.remove('animate-pulse');
            }
        });
    });
    
    // Task deletion with animation
    document.querySelectorAll('.delete-task').forEach(button => {
        button.addEventListener('click', async function() {
            if (!confirm('Удалить задачу?')) return;
            
            const taskId = this.dataset.id;
            
            // Add loading state
            this.innerHTML = '<svg class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            
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
                
                // Remove task card from UI with animation
                const taskCard = this.closest('.task-card');
                if (taskCard) {
                    taskCard.style.transition = 'all 0.3s ease';
                    taskCard.style.opacity = '0';
                    taskCard.style.transform = 'translateX(-100%)';
                    setTimeout(() => {
                        taskCard.remove();
                    }, 300);
                }
            } catch (error) {
                console.error('Error deleting task:', error);
                alert('Ошибка при удалении задачи');
                // Restore button
                this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>';
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
                // Add error animation
                titleInput.classList.add('border-red-500', 'animate-pulse');
                setTimeout(() => {
                    titleInput.classList.remove('border-red-500', 'animate-pulse');
                }, 1000);
                return;
            }
            
            // Add loading state to submit button
            const submitButton = taskForm.querySelector('button[type="submit"]');
            const originalContent = submitButton.innerHTML;
            submitButton.innerHTML = '<svg class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            submitButton.disabled = true;
            
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
                
                // Reload the page to show the new task
                window.location.reload();
            } catch (error) {
                console.error('Error creating task:', error);
                alert('Ошибка при создании задачи');
            } finally {
                // Restore submit button
                submitButton.innerHTML = originalContent;
                submitButton.disabled = false;
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
            
            // Add loading state to submit button
            const submitButton = editTaskForm.querySelector('button[type="submit"]');
            const originalContent = submitButton.innerHTML;
            submitButton.innerHTML = '<svg class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            submitButton.disabled = true;
            
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
                window.location.reload();
            } catch (error) {
                console.error('Error updating task:', error);
                alert('Ошибка при обновлении задачи');
            } finally {
                // Restore submit button
                submitButton.innerHTML = originalContent;
                submitButton.disabled = false;
            }
        });
    }
    
    // Search form enhancements
    const searchForm = document.querySelector('form[action*="tasks"]');
    if (searchForm) {
        const searchInput = searchForm.querySelector('input[name="search"]');
        if (searchInput) {
            // Clear search on ESC key
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && this.value) {
                    this.value = '';
                    searchForm.submit();
                }
            });
        }
    }
});

// Modal functions
function openEditModal(taskId) {
    currentTaskId = taskId;
    const editTaskModal = document.getElementById('editTaskModal');
    if (editTaskModal) {
        editTaskModal.classList.remove('hidden');
        editTaskModal.classList.add('block');
        
        // Fetch task data and populate form
        fetch(`/tasks/${taskId}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit-title').value = data.title;
                document.getElementById('edit-description').value = data.description || '';
                document.getElementById('edit-completed').checked = data.completed;
            })
            .catch(error => {
                console.error('Error fetching task:', error);
                alert('Ошибка при загрузке данных задачи');
            });
    }
}

function closeEditModal() {
    const editTaskModal = document.getElementById('editTaskModal');
    if (editTaskModal) {
        editTaskModal.classList.remove('block');
        editTaskModal.classList.add('hidden');
        currentTaskId = null;
    }
}