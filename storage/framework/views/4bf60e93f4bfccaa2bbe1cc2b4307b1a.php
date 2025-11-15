

<?php $__env->startSection('header'); ?>
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        Мои задачи
    </h2>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 shadow-sm sticky top-16 z-40">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-5">
                <h1 class="text-3xl font-bold text-gray-900">Мои задачи</h1>
                <div class="grid grid-cols-3 gap-5 text-base">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900"><?php echo e(auth()->user()->tasks()->count()); ?></div>
                        <div class="text-gray-500">Всего</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600"><?php echo e(auth()->user()->tasks()->where('completed', false)->count()); ?></div>
                        <div class="text-gray-500">Активные</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600"><?php echo e(auth()->user()->tasks()->where('completed', true)->count()); ?></div>
                        <div class="text-gray-500">Завершены</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Progress Bar -->
        <?php
            $totalTasks = auth()->user()->tasks()->count();
            $completedTasks = auth()->user()->tasks()->where('completed', true)->count();
            $progressPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        ?>
        
        <?php if($totalTasks > 0): ?>
            <div class="mb-10">
                <?php if (isset($component)) { $__componentOriginalc1838dab69175fa625a76ca35492c358 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc1838dab69175fa625a76ca35492c358 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.progress-bar','data' => ['percentage' => $progressPercentage,'label' => 'Прогресс выполнения']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('progress-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($progressPercentage),'label' => 'Прогресс выполнения']); ?>
                    <?php echo e($completedTasks); ?> из <?php echo e($totalTasks); ?> задач выполнено
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc1838dab69175fa625a76ca35492c358)): ?>
<?php $attributes = $__attributesOriginalc1838dab69175fa625a76ca35492c358; ?>
<?php unset($__attributesOriginalc1838dab69175fa625a76ca35492c358); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc1838dab69175fa625a76ca35492c358)): ?>
<?php $component = $__componentOriginalc1838dab69175fa625a76ca35492c358; ?>
<?php unset($__componentOriginalc1838dab69175fa625a76ca35492c358); ?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Add Task Form -->
        <?php if (isset($component)) { $__componentOriginal1213088c491ad27af228723338a4a888 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1213088c491ad27af228723338a4a888 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.task-form','data' => ['class' => 'mb-10']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('task-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-10']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1213088c491ad27af228723338a4a888)): ?>
<?php $attributes = $__attributesOriginal1213088c491ad27af228723338a4a888; ?>
<?php unset($__attributesOriginal1213088c491ad27af228723338a4a888); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1213088c491ad27af228723338a4a888)): ?>
<?php $component = $__componentOriginal1213088c491ad27af228723338a4a888; ?>
<?php unset($__componentOriginal1213088c491ad27af228723338a4a888); ?>
<?php endif; ?>

        <!-- Search and Filters -->
        <?php if (isset($component)) { $__componentOriginalc846d12936cd11f6bc3fa89c4978ab1c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc846d12936cd11f6bc3fa89c4978ab1c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.task-filters','data' => ['currentFilter' => $filter,'searchQuery' => request('search'),'class' => 'mb-10']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('task-filters'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['current-filter' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filter),'search-query' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('search')),'class' => 'mb-10']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc846d12936cd11f6bc3fa89c4978ab1c)): ?>
<?php $attributes = $__attributesOriginalc846d12936cd11f6bc3fa89c4978ab1c; ?>
<?php unset($__attributesOriginalc846d12936cd11f6bc3fa89c4978ab1c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc846d12936cd11f6bc3fa89c4978ab1c)): ?>
<?php $component = $__componentOriginalc846d12936cd11f6bc3fa89c4978ab1c; ?>
<?php unset($__componentOriginalc846d12936cd11f6bc3fa89c4978ab1c); ?>
<?php endif; ?>

        <!-- Tasks List -->
        <?php if($tasks->count() > 0): ?>
            <?php if($filter === 'all'): ?>
                <!-- Use drag and drop for all tasks view -->
                <?php if (isset($component)) { $__componentOriginal0eb2861ead050f77aac1bcccb02b1de4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0eb2861ead050f77aac1bcccb02b1de4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.drag-drop-task-list','data' => ['tasks' => $tasks]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('drag-drop-task-list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tasks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tasks)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0eb2861ead050f77aac1bcccb02b1de4)): ?>
<?php $attributes = $__attributesOriginal0eb2861ead050f77aac1bcccb02b1de4; ?>
<?php unset($__attributesOriginal0eb2861ead050f77aac1bcccb02b1de4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0eb2861ead050f77aac1bcccb02b1de4)): ?>
<?php $component = $__componentOriginal0eb2861ead050f77aac1bcccb02b1de4; ?>
<?php unset($__componentOriginal0eb2861ead050f77aac1bcccb02b1de4); ?>
<?php endif; ?>
            <?php else: ?>
                <!-- Use regular list for filtered views -->
                <div class="space-y-5">
                    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginal5c7e45c1b38a85fb63a7b75e56a24d35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c7e45c1b38a85fb63a7b75e56a24d35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.task-card','data' => ['task' => $task]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('task-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['task' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($task)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5c7e45c1b38a85fb63a7b75e56a24d35)): ?>
<?php $attributes = $__attributesOriginal5c7e45c1b38a85fb63a7b75e56a24d35; ?>
<?php unset($__attributesOriginal5c7e45c1b38a85fb63a7b75e56a24d35); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5c7e45c1b38a85fb63a7b75e56a24d35)): ?>
<?php $component = $__componentOriginal5c7e45c1b38a85fb63a7b75e56a24d35; ?>
<?php unset($__componentOriginal5c7e45c1b38a85fb63a7b75e56a24d35); ?>
<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <?php switch($filter):
                    case ('pending'): ?>
                        <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'Все задачи выполнены!','description' => '🎉 Поздравляем! У вас нет активных задач.','icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Все задачи выполнены!','description' => '🎉 Поздравляем! У вас нет активных задач.','icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
                    <?php break; ?>
                    <?php case ('completed'): ?>
                        <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'Нет завершённых задач','description' => 'У вас ещё нет завершённых задач. Продолжайте работать!','icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Нет завершённых задач','description' => 'У вас ещё нет завершённых задач. Продолжайте работать!','icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
                    <?php break; ?>
                    <?php default: ?>
                        <?php if(request('search')): ?>
                            <x-empty-state
                                title="Ничего не найдено"
                                description='По вашему запросу "<?php echo e(request('search')); ?>" ничего не найдено.'
                                icon='<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>'
                            />
                        <?php else: ?>
                            <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'Нет задач','description' => 'Начните с создания своей первой задачи!','icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>','actionText' => 'Создать задачу','actionUrl' => ''.e(route('tasks.index')).'#task-form']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Нет задач','description' => 'Начните с создания своей первой задачи!','icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>','action-text' => 'Создать задачу','action-url' => ''.e(route('tasks.index')).'#task-form']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
                        <?php endif; ?>
                <?php endswitch; ?>
            </div>
        <?php endif; ?>
        
        <!-- Pagination -->
        <?php if($tasks->hasPages()): ?>
            <div class="mt-12 bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex justify-center">
                    <?php echo e($tasks->appends(request()->except('page'))->links()); ?>

                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Edit Task Modal -->
<?php if (isset($component)) { $__componentOriginal90bba21216398bc0c4d9b368855cda0b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal90bba21216398bc0c4d9b368855cda0b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.edit-task-modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('edit-task-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal90bba21216398bc0c4d9b368855cda0b)): ?>
<?php $attributes = $__attributesOriginal90bba21216398bc0c4d9b368855cda0b; ?>
<?php unset($__attributesOriginal90bba21216398bc0c4d9b368855cda0b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal90bba21216398bc0c4d9b368855cda0b)): ?>
<?php $component = $__componentOriginal90bba21216398bc0c4d9b368855cda0b; ?>
<?php unset($__componentOriginal90bba21216398bc0c4d9b368855cda0b); ?>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('task-form');
    
    // Add task
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        const dueDate = document.getElementById('due_date').value;
        
        if (!title) return;

        try {
            const res = await fetch('<?php echo e(route("tasks.store")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ 
                    title, 
                    description: description || null,
                    due_date: dueDate || null
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
            document.getElementById('edit-completed').checked = task.completed;
            
            // Set form action
            editForm.action = `/tasks/${taskId}`;
            
            // Show modal
            editModal.classList.remove('hidden');
        } catch (error) {
            console.error('Ошибка:', error);
            alert('Не удалось загрузить данные задачи');
        }
    });
    
    // Close modal
    cancelEdit.addEventListener('click', () => {
        editModal.classList.add('hidden');
    });
    
    // Close modal when clicking outside
    editModal.addEventListener('click', (e) => {
        if (e.target === editModal) {
            editModal.classList.add('hidden');
        }
    });
    
    // Save edited task
    editForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(editForm);
        const data = {
            title: formData.get('title'),
            description: formData.get('description') || null,
            due_date: formData.get('due_date') || null,
            completed: formData.get('completed') === '1'
        };
        
        try {
            const res = await fetch(editForm.action, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            });
            
            if (res.ok) {
                window.location.reload();
            } else {
                const error = await res.json();
                alert(error.message || 'Ошибка при сохранении задачи');
            }
        } catch (error) {
            console.error('Ошибка:', error);
            alert('Ошибка при сохранении задачи');
        }
    });

    // Toggle task completion
    document.addEventListener('change', async (e) => {
        if (e.target.classList.contains('task-toggle')) {
            const taskId = e.target.dataset.id;
            const completed = e.target.checked;

            try {
                const res = await fetch(`/tasks/${taskId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ completed })
                });
                
                if (!res.ok) {
                    const error = await res.json();
                    throw new Error(error.message || 'Ошибка при обновлении статуса');
                }
                
                window.location.reload();
            } catch (error) {
                console.error('Ошибка:', error);
                alert(error.message || 'Ошибка при обновлении статуса задачи');
                // Restore previous state
                e.target.checked = !completed;
            }
        }
    });

    // Delete task
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.delete-task');
        if (!btn) return;
        
        if (!confirm('Удалить задачу?')) return;
        
        const taskId = btn.dataset.id;

        try {
            const res = await fetch(`/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            if (!res.ok) {
                const error = await res.json();
                throw new Error(error.message || 'Ошибка при удалении задачи');
            }
            
            window.location.reload();
        } catch (error) {
            console.error('Ошибка при удалении:', error);
            alert(error.message || 'Ошибка при удалении задачи');
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/tasks/index.blade.php ENDPATH**/ ?>