

<?php $__env->startSection('header'); ?>
    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
        <?php echo e(__('Dashboard')); ?>

    </h2>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">👋 Добро пожаловать, <?php echo e(Auth::user()->name); ?>!</h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Вот обзор вашей продуктивности</p>
                    </div>
                    <div class="hidden md:flex items-center space-x-3">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Сегодня</span>
                        <span class="text-lg font-semibold text-indigo-600 dark:text-indigo-400"><?php echo e(\Carbon\Carbon::now()->format('d M, Y')); ?></span>
                    </div>
                </div>
            </div>
                        
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Всего задач</p>
                            <p class="text-3xl font-bold mt-2"><?php echo e($totalTasks); ?></p>
                            <p class="text-blue-100 text-xs mt-1">Все ваши задачи</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm font-medium">Активные</p>
                            <p class="text-3xl font-bold mt-2"><?php echo e($pendingTasks); ?></p>
                            <p class="text-yellow-100 text-xs mt-1">Еще не завершены</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Завершены</p>
                            <p class="text-3xl font-bold mt-2"><?php echo e($completedTasks); ?></p>
                            <p class="text-green-100 text-xs mt-1">Выполненные задачи</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <?php if($donationStats['count'] > 0): ?>
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Донаты</p>
                                <p class="text-3xl font-bold mt-2"><?php echo e($donationStats['count']); ?></p>
                                <p class="text-purple-100 text-xs mt-1"><?php echo e(number_format($donationStats['amount'], 2)); ?> ₽</p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-full p-3">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-indigo-100 text-sm font-medium">Донаты</p>
                                <p class="text-3xl font-bold mt-2">0</p>
                                <p class="text-indigo-100 text-xs mt-1">
                                    <a href="<?php echo e(route('donations.my')); ?>" class="hover:underline">Создать первый →</a>
                                </p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-full p-3">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
                        
                        <!-- Рекомендации и умные подсказки -->
                        <?php if (isset($component)) { $__componentOriginal493ffe803661bb40fb31ef6ef839ccf3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal493ffe803661bb40fb31ef6ef839ccf3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard-recommendations','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard-recommendations'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal493ffe803661bb40fb31ef6ef839ccf3)): ?>
<?php $attributes = $__attributesOriginal493ffe803661bb40fb31ef6ef839ccf3; ?>
<?php unset($__attributesOriginal493ffe803661bb40fb31ef6ef839ccf3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal493ffe803661bb40fb31ef6ef839ccf3)): ?>
<?php $component = $__componentOriginal493ffe803661bb40fb31ef6ef839ccf3; ?>
<?php unset($__componentOriginal493ffe803661bb40fb31ef6ef839ccf3); ?>
<?php endif; ?>
                        
                        <!-- Игровой прогресс -->
                        <?php if (isset($component)) { $__componentOriginal77f189266873d519d0895b84f8239794 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal77f189266873d519d0895b84f8239794 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard-gamification','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard-gamification'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal77f189266873d519d0895b84f8239794)): ?>
<?php $attributes = $__attributesOriginal77f189266873d519d0895b84f8239794; ?>
<?php unset($__attributesOriginal77f189266873d519d0895b84f8239794); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal77f189266873d519d0895b84f8239794)): ?>
<?php $component = $__componentOriginal77f189266873d519d0895b84f8239794; ?>
<?php unset($__componentOriginal77f189266873d519d0895b84f8239794); ?>
<?php endif; ?>
                        
                        <!-- Недавняя активность -->
                        <?php if (isset($component)) { $__componentOriginal54f8e7e739c02f5471d42d29af744b9e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal54f8e7e739c02f5471d42d29af744b9e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard-activity','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard-activity'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal54f8e7e739c02f5471d42d29af744b9e)): ?>
<?php $attributes = $__attributesOriginal54f8e7e739c02f5471d42d29af744b9e; ?>
<?php unset($__attributesOriginal54f8e7e739c02f5471d42d29af744b9e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal54f8e7e739c02f5471d42d29af744b9e)): ?>
<?php $component = $__componentOriginal54f8e7e739c02f5471d42d29af744b9e; ?>
<?php unset($__componentOriginal54f8e7e739c02f5471d42d29af744b9e); ?>
<?php endif; ?>
                        
                        <!-- Progress Section -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
                            <!-- Progress Bar -->
                            <?php if($totalTasks > 0): ?>
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                                <?php if (isset($component)) { $__componentOriginalc1838dab69175fa625a76ca35492c358 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc1838dab69175fa625a76ca35492c358 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.progress-bar','data' => ['percentage' => $completionPercentage,'label' => 'Прогресс выполнения']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('progress-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['percentage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($completionPercentage),'label' => 'Прогресс выполнения']); ?>
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
                                
                                <!-- Completion Stats -->
                                <div class="mt-8 grid grid-cols-2 gap-4">
                                    <div class="text-center p-4 bg-green-50 dark:bg-green-900/30 rounded-xl">
                                        <div class="text-3xl font-bold text-green-600 dark:text-green-400"><?php echo e($completedTasks); ?></div>
                                        <div class="text-base text-green-700 dark:text-green-300 mt-1">Завершено</div>
                                    </div>
                                    <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/30 rounded-xl">
                                        <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400"><?php echo e($pendingTasks); ?></div>
                                        <div class="text-base text-yellow-700 dark:text-yellow-300 mt-1">В процессе</div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Activity Chart -->
                            <?php if($tasksByDay->count() > 0): ?>
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Активность за неделю</h3>
                                <div class="h-48 flex items-end justify-between gap-3">
                                    <?php $__currentLoopData = $tasksByDay; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex flex-col items-center flex-1">
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-t-lg overflow-hidden" style="height: 120px;">
                                                <div class="bg-indigo-500 dark:bg-indigo-400 w-full rounded-t-lg" 
                                                     style="height: <?php echo ($tasksByDay->max('count') > 0) ? ($day->count / $tasksByDay->max('count')) * 100 : 0; ?>%"></div>
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-3">
                                                <?php echo e(\Carbon\Carbon::parse($day->date)->format('d.m')); ?>

                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Recent Tasks -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Последние задачи</h3>
                                <a href="<?php echo e(route('tasks.index')); ?>" 
                                   class="text-base text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium transition-colors duration-200">
                                    Просмотреть все
                                </a>
                            </div>
                            
                            <?php if($recentTasks->count() > 0): ?>
                                <div class="space-y-4">
                                    <?php $__currentLoopData = $recentTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if (isset($component)) { $__componentOriginal5c7e45c1b38a85fb63a7b75e56a24d35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c7e45c1b38a85fb63a7b75e56a24d35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.task-card','data' => ['task' => $task,'showActions' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('task-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['task' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($task),'show-actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
                                <div class="mt-8">
                                    <a href="<?php echo e(route('tasks.index')); ?>" 
                                       class="inline-flex items-center px-5 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        Просмотреть все задачи
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <h3 class="mt-4 text-xl font-medium text-gray-900 dark:text-gray-100">Нет задач</h3>
                                    <p class="mt-2 text-gray-600 dark:text-gray-400">Начните с создания своей первой задачи.</p>
                                    <div class="mt-8">
                                        <a href="<?php echo e(route('tasks.index')); ?>" 
                                           class="inline-flex items-center px-5 py-3 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-lg font-semibold text-white hover:bg-indigo-700 dark:hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                            Создать задачу
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    
    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle task completion
            document.querySelectorAll('.task-toggle').forEach(checkbox => {
                checkbox.addEventListener('change', async function() {
                    const taskId = this.dataset.taskId;
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
                        
                        // Reload the page to reflect changes
                        window.location.reload();
                    } catch (error) {
                        console.error('Error updating task:', error);
                        // Revert the checkbox state
                        this.checked = !completed;
                        alert('Ошибка при обновлении задачи');
                    }
                });
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/user-dashboard.blade.php ENDPATH**/ ?>