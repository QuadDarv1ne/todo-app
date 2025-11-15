<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">📊 Недавняя активность</h3>
            <a href="<?php echo e(route('activity-logs.index')); ?>" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                Вся история →
            </a>
        </div>

        <?php
            $recentLogs = auth()->user()->activityLogs()->take(5)->get();
        ?>

        <?php if($recentLogs->isNotEmpty()): ?>
            <div class="space-y-3">
                <?php $__currentLoopData = $recentLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border-l-4 border-<?php echo e($log->action_color); ?>-500 bg-<?php echo e($log->action_color); ?>-50 p-3 rounded-r-lg">
                        <div class="flex items-start gap-2">
                            <span class="text-xl"><?php echo e($log->action_icon); ?></span>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-sm font-semibold text-gray-900"><?php echo e($log->action_label); ?></span>
                                    <?php if($log->model_type): ?>
                                        <span class="text-xs px-2 py-0.5 bg-<?php echo e($log->action_color); ?>-200 text-<?php echo e($log->action_color); ?>-800 rounded-full">
                                            <?php echo e(class_basename($log->model_type)); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-xs text-gray-700 line-clamp-2"><?php echo e($log->description); ?></p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <div class="text-xs text-gray-500">
                                    <?php echo e($log->created_at->diffForHumans()); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Краткая статистика -->
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="grid grid-cols-3 gap-2 text-center">
                    <div class="bg-green-50 rounded p-2">
                        <div class="text-xs text-green-700 font-medium">Создано</div>
                        <div class="text-lg font-bold text-green-900">
                            <?php echo e(auth()->user()->activityLogs()->where('action', 'created')->count()); ?>

                        </div>
                    </div>
                    <div class="bg-blue-50 rounded p-2">
                        <div class="text-xs text-blue-700 font-medium">Завершено</div>
                        <div class="text-lg font-bold text-blue-900">
                            <?php echo e(auth()->user()->activityLogs()->where('action', 'completed')->count()); ?>

                        </div>
                    </div>
                    <div class="bg-purple-50 rounded p-2">
                        <div class="text-xs text-purple-700 font-medium">Достижений</div>
                        <div class="text-lg font-bold text-purple-900">
                            <?php echo e(auth()->user()->activityLogs()->where('action', 'achievement_unlocked')->count()); ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-2 text-sm text-gray-500">История активности пока пуста</p>
                <p class="text-xs text-gray-400">Выполняйте задачи, чтобы увидеть свою активность!</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/components/dashboard-activity.blade.php ENDPATH**/ ?>