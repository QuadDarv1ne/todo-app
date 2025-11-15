<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">🎮 Игровой прогресс</h3>
            <a href="<?php echo e(route('achievements.index')); ?>" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                Все достижения →
            </a>
        </div>

        <!-- Уровень и опыт -->
        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <div class="text-sm text-gray-600">Уровень</div>
                    <div class="text-3xl font-bold text-indigo-600"><?php echo e(auth()->user()->level); ?></div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-600">Опыт</div>
                    <div class="text-2xl font-bold text-purple-600"><?php echo e(auth()->user()->experience_points); ?> XP</div>
                </div>
            </div>

            <?php
                $currentLevel = auth()->user()->level;
                $currentXP = auth()->user()->experience_points;
                $currentLevelXP = pow($currentLevel, 2) * 100;
                $nextLevelXP = pow($currentLevel + 1, 2) * 100;
                $levelProgress = $nextLevelXP > $currentLevelXP 
                    ? (($currentXP - $currentLevelXP) / ($nextLevelXP - $currentLevelXP)) * 100 
                    : 0;
            ?>

            <div class="w-full bg-white rounded-full h-3 overflow-hidden shadow-inner">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full transition-all duration-500"
                     style="width: <?php echo e(min($levelProgress, 100)); ?>%"></div>
            </div>
            <div class="text-xs text-gray-600 mt-1 text-center">
                <?php echo e(number_format($currentXP - $currentLevelXP)); ?> / <?php echo e(number_format($nextLevelXP - $currentLevelXP)); ?> XP
                (<?php echo e(number_format($levelProgress, 1)); ?>%)
            </div>
        </div>

        <!-- Статистика -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div class="bg-green-50 rounded-lg p-3">
                <div class="text-xs text-green-700 font-medium">Серия дней</div>
                <div class="text-xl font-bold text-green-900"><?php echo e(auth()->user()->streak_days); ?> 🔥</div>
            </div>
            <div class="bg-blue-50 rounded-lg p-3">
                <div class="text-xs text-blue-700 font-medium">Достижения</div>
                <div class="text-xl font-bold text-blue-900">
                    <?php echo e(auth()->user()->achievements->count()); ?> / <?php echo e(\App\Models\Achievement::count()); ?>

                </div>
            </div>
        </div>

        <!-- Последние достижения -->
        <?php
            $recentAchievements = auth()->user()->achievements()
                ->orderBy('user_achievements.unlocked_at', 'desc')
                ->take(3)
                ->get();
        ?>

        <?php if($recentAchievements->isNotEmpty()): ?>
            <div class="border-t pt-4">
                <h4 class="text-sm font-bold text-gray-700 mb-3">Недавние достижения</h4>
                <div class="space-y-2">
                    <?php $__currentLoopData = $recentAchievements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $achievement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg p-2 border border-yellow-200">
                            <span class="text-2xl mr-2"><?php echo e($achievement->icon); ?></span>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-semibold text-gray-900 truncate">
                                    <?php echo e($achievement->name); ?>

                                </div>
                                <div class="text-xs text-gray-600">
                                    +<?php echo e($achievement->points); ?> XP
                                </div>
                            </div>
                            <div class="text-xs text-gray-500">
                                <?php echo e(\Carbon\Carbon::parse($achievement->pivot->unlocked_at)->diffForHumans()); ?>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php else: ?>
            <div class="border-t pt-4">
                <p class="text-sm text-gray-500 text-center">
                    Выполняйте задачи, чтобы открыть достижения! 🎯
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/components/dashboard-gamification.blade.php ENDPATH**/ ?>