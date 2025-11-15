<!-- Рекомендации -->
<?php if(isset($recommendations) && count($recommendations) > 0): ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
            Умные рекомендации
        </h3>
        
        <div class="space-y-3">
            <?php $__currentLoopData = $recommendations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recommendation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-start gap-4 p-4 rounded-lg border <?php echo e($recommendation['urgency'] === 'high' ? 'bg-red-50 border-red-200' : ($recommendation['urgency'] === 'medium' ? 'bg-yellow-50 border-yellow-200' : 'bg-blue-50 border-blue-200')); ?>">
                    <!-- Иконка -->
                    <div class="flex-shrink-0 mt-0.5">
                        <?php switch($recommendation['icon']):
                            case ('alert'): ?>
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            <?php break; ?>
                            <?php case ('priority'): ?>
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                </svg>
                            <?php break; ?>
                            <?php case ('calendar'): ?>
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            <?php break; ?>
                            <?php case ('trophy'): ?>
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                            <?php break; ?>
                            <?php case ('chart'): ?>
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            <?php break; ?>
                            <?php case ('tag'): ?>
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            <?php break; ?>
                            <?php default: ?>
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                        <?php endswitch; ?>
                    </div>
                    
                    <!-- Контент -->
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-semibold text-gray-900 mb-1"><?php echo e($recommendation['title']); ?></h4>
                        <p class="text-sm text-gray-600 mb-2"><?php echo e($recommendation['description']); ?></p>
                        <a href="<?php echo e($recommendation['action_url']); ?>" 
                           class="inline-flex items-center text-sm font-medium <?php echo e($recommendation['urgency'] === 'high' ? 'text-red-700 hover:text-red-800' : ($recommendation['urgency'] === 'medium' ? 'text-yellow-700 hover:text-yellow-800' : 'text-blue-700 hover:text-blue-800')); ?>">
                            <?php echo e($recommendation['action']); ?>

                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>

<!-- Производительность -->
<?php if(isset($performance)): ?>
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg p-6 mb-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold mb-2">Ваша производительность</h3>
                <div class="flex items-baseline gap-3">
                    <span class="text-4xl font-bold"><?php echo e($performance['score']); ?></span>
                    <span class="text-2xl"><?php echo e($performance['badge']); ?></span>
                    <span class="text-lg opacity-90"><?php echo e($performance['level']); ?></span>
                </div>
                <div class="mt-3 space-y-1 text-sm opacity-90">
                    <p>📊 Завершено задач: <?php echo e($performance['completion_rate']); ?>%</p>
                    <p>⏰ Выполнено в срок: <?php echo e($performance['on_time_rate']); ?>%</p>
                </div>
            </div>
            <div class="hidden md:block">
                <svg class="w-24 h-24 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Следующая рекомендуемая задача -->
<?php if(isset($nextTask) && $nextTask): ?>
    <div class="bg-white rounded-lg shadow-sm border-2 border-indigo-200 p-6 mb-6">
        <h3 class="text-sm font-medium text-indigo-600 mb-2">🎯 СЛЕДУЮЩАЯ ЗАДАЧА</h3>
        <h4 class="text-xl font-bold text-gray-900 mb-2"><?php echo e($nextTask->title); ?></h4>
        <?php if($nextTask->description): ?>
            <p class="text-sm text-gray-600 mb-3"><?php echo e(Str::limit($nextTask->description, 100)); ?></p>
        <?php endif; ?>
        <div class="flex items-center gap-4 text-sm">
            <?php if($nextTask->due_date): ?>
                <span class="flex items-center text-gray-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <?php echo e($nextTask->due_date->format('d.m.Y')); ?>

                </span>
            <?php endif; ?>
            <span class="px-2 py-1 rounded-full text-xs font-medium <?php echo e($nextTask->priority === 'high' ? 'bg-red-100 text-red-800' : ($nextTask->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800')); ?>">
                <?php echo e($nextTask->priority_name); ?>

            </span>
        </div>
    </div>
<?php endif; ?>

<!-- Задачи на сегодня -->
<?php if(isset($todayTasks) && $todayTasks->count() > 0): ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Задачи на сегодня
        </h3>
        
        <div class="space-y-2">
            <?php $__currentLoopData = $todayTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <input type="checkbox" 
                               class="w-4 h-4 text-indigo-600 rounded focus:ring-indigo-500"
                               <?php echo e($task->completed ? 'checked' : ''); ?>>
                        <span class="text-sm font-medium text-gray-900 truncate"><?php echo e($task->title); ?></span>
                    </div>
                    <span class="flex-shrink-0 px-2 py-1 rounded-full text-xs font-medium ml-2 <?php echo e($task->priority === 'high' ? 'bg-red-100 text-red-800' : ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800')); ?>">
                        <?php echo e($task->priority_name); ?>

                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <a href="<?php echo e(route('tasks.index', ['due_date' => 'today'])); ?>" 
           class="mt-4 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">
            Посмотреть все задачи на сегодня
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/components/dashboard-recommendations.blade.php ENDPATH**/ ?>