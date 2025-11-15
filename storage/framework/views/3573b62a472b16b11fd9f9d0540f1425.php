

<?php $__env->startSection('header'); ?>
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        <?php echo e(__('Dashboard')); ?>

    </h2>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-8">
                    <div class="mb-10">
                        <h3 class="text-3xl font-bold text-gray-800 mb-8">Добро пожаловать, <?php echo e(Auth::user()->name); ?>!</h3>
                        
                        <!-- Stats Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                            <?php if (isset($component)) { $__componentOriginal8f216e051c231b98198765acd723fb77 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f216e051c231b98198765acd723fb77 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stats-card','data' => ['title' => 'Всего задач','value' => $totalTasks,'description' => 'Все ваши задачи','color' => 'blue']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stats-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Всего задач','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalTasks),'description' => 'Все ваши задачи','color' => 'blue']); ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f216e051c231b98198765acd723fb77)): ?>
<?php $attributes = $__attributesOriginal8f216e051c231b98198765acd723fb77; ?>
<?php unset($__attributesOriginal8f216e051c231b98198765acd723fb77); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f216e051c231b98198765acd723fb77)): ?>
<?php $component = $__componentOriginal8f216e051c231b98198765acd723fb77; ?>
<?php unset($__componentOriginal8f216e051c231b98198765acd723fb77); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginal8f216e051c231b98198765acd723fb77 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f216e051c231b98198765acd723fb77 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stats-card','data' => ['title' => 'Активные','value' => $pendingTasks,'description' => 'Еще не завершены','color' => 'yellow']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stats-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Активные','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pendingTasks),'description' => 'Еще не завершены','color' => 'yellow']); ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f216e051c231b98198765acd723fb77)): ?>
<?php $attributes = $__attributesOriginal8f216e051c231b98198765acd723fb77; ?>
<?php unset($__attributesOriginal8f216e051c231b98198765acd723fb77); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f216e051c231b98198765acd723fb77)): ?>
<?php $component = $__componentOriginal8f216e051c231b98198765acd723fb77; ?>
<?php unset($__componentOriginal8f216e051c231b98198765acd723fb77); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginal8f216e051c231b98198765acd723fb77 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f216e051c231b98198765acd723fb77 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stats-card','data' => ['title' => 'Завершены','value' => $completedTasks,'description' => 'Выполненные задачи','color' => 'green']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stats-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Завершены','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($completedTasks),'description' => 'Выполненные задачи','color' => 'green']); ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f216e051c231b98198765acd723fb77)): ?>
<?php $attributes = $__attributesOriginal8f216e051c231b98198765acd723fb77; ?>
<?php unset($__attributesOriginal8f216e051c231b98198765acd723fb77); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f216e051c231b98198765acd723fb77)): ?>
<?php $component = $__componentOriginal8f216e051c231b98198765acd723fb77; ?>
<?php unset($__componentOriginal8f216e051c231b98198765acd723fb77); ?>
<?php endif; ?>
                            
                            <!-- Donation Stats Widget -->
                            <?php if($donationStats['count'] > 0): ?>
                                <?php if (isset($component)) { $__componentOriginal5bd0621f16806bbc12539851ad6aeae4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bd0621f16806bbc12539851ad6aeae4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.donation-stats-widget','data' => ['donationsCount' => $donationStats['count'],'totalAmount' => $donationStats['amount'],'currenciesCount' => $donationStats['currencies']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('donation-stats-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['donations-count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($donationStats['count']),'total-amount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($donationStats['amount']),'currencies-count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($donationStats['currencies'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bd0621f16806bbc12539851ad6aeae4)): ?>
<?php $attributes = $__attributesOriginal5bd0621f16806bbc12539851ad6aeae4; ?>
<?php unset($__attributesOriginal5bd0621f16806bbc12539851ad6aeae4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bd0621f16806bbc12539851ad6aeae4)): ?>
<?php $component = $__componentOriginal5bd0621f16806bbc12539851ad6aeae4; ?>
<?php unset($__componentOriginal5bd0621f16806bbc12539851ad6aeae4); ?>
<?php endif; ?>
                            <?php else: ?>
                                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                                    <div class="p-5">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-500">Донаты</p>
                                                <p class="text-2xl font-bold text-gray-900">0</p>
                                            </div>
                                            <div class="bg-indigo-100 rounded-full p-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <a href="<?php echo e(route('donations.my')); ?>" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                                Создать первый донат
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Progress Section -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
                            <!-- Progress Bar -->
                            <?php if($totalTasks > 0): ?>
                            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
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
                                    <div class="text-center p-4 bg-green-50 rounded-xl">
                                        <div class="text-3xl font-bold text-green-600"><?php echo e($completedTasks); ?></div>
                                        <div class="text-base text-green-700 mt-1">Завершено</div>
                                    </div>
                                    <div class="text-center p-4 bg-yellow-50 rounded-xl">
                                        <div class="text-3xl font-bold text-yellow-600"><?php echo e($pendingTasks); ?></div>
                                        <div class="text-base text-yellow-700 mt-1">В процессе</div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Activity Chart -->
                            <?php if($tasksByDay->count() > 0): ?>
                            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6">Активность за неделю</h3>
                                <div class="h-48 flex items-end justify-between gap-3">
                                    <?php $__currentLoopData = $tasksByDay; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex flex-col items-center flex-1">
                                            <div class="w-full bg-gray-200 rounded-t-lg overflow-hidden" style="height: 120px;">
                                                <div class="bg-indigo-500 w-full rounded-t-lg" 
                                                     style="height: <?php echo ($tasksByDay->max('count') > 0) ? ($day->count / $tasksByDay->max('count')) * 100 : 0; ?>%"></div>
                                            </div>
                                            <div class="text-sm text-gray-500 mt-3">
                                                <?php echo e(\Carbon\Carbon::parse($day->date)->format('d.m')); ?>

                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Recent Tasks -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-semibold text-gray-900">Последние задачи</h3>
                                <a href="<?php echo e(route('tasks.index')); ?>" 
                                   class="text-base text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200">
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
                                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <h3 class="mt-4 text-xl font-medium text-gray-900">Нет задач</h3>
                                    <p class="mt-2 text-gray-600">Начните с создания своей первой задачи.</p>
                                    <div class="mt-8">
                                        <a href="<?php echo e(route('tasks.index')); ?>" 
                                           class="inline-flex items-center px-5 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
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