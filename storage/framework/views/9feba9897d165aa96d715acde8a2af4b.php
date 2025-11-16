<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            <?php echo e(__('Профиль')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Information Card -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="max-w-xl">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex-shrink-0 w-16 h-16 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                            <span class="text-xl font-bold text-indigo-700 dark:text-indigo-300"><?php echo e(substr($user->name, 0, 1)); ?></span>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Информация профиля</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Управляйте информацией вашего аккаунта</p>
                        </div>
                    </div>
                    <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

            <!-- Notifications Card -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="max-w-4xl">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex-shrink-0 w-16 h-16 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Уведомления</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Управляйте вашими уведомлениями</p>
                        </div>
                    </div>
                    
                    <?php echo $__env->make('profile.partials.reminder-settings-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                    <div class="space-y-4 mt-8">
                        <?php $__empty_1 = true; $__currentLoopData = $user->notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php if (isset($component)) { $__componentOriginal0d8d3c14ebd2b92d484be47e6c018839 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0d8d3c14ebd2b92d484be47e6c018839 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notification','data' => ['type' => $notification->data['type'] === 'task_limit_approaching' ? 'warning' : 'info','title' => $notification->data['type'] === 'task_limit_approaching' ? 'Предупреждение о лимите задач' : 'Уведомление','message' => $notification->data['message'] ?? 'Новое уведомление','time' => $notification->created_at->diffForHumans(),'unread' => is_null($notification->read_at)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('notification'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notification->data['type'] === 'task_limit_approaching' ? 'warning' : 'info'),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notification->data['type'] === 'task_limit_approaching' ? 'Предупреждение о лимите задач' : 'Уведомление'),'message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notification->data['message'] ?? 'Новое уведомление'),'time' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notification->created_at->diffForHumans()),'unread' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(is_null($notification->read_at))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0d8d3c14ebd2b92d484be47e6c018839)): ?>
<?php $attributes = $__attributesOriginal0d8d3c14ebd2b92d484be47e6c018839; ?>
<?php unset($__attributesOriginal0d8d3c14ebd2b92d484be47e6c018839); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0d8d3c14ebd2b92d484be47e6c018839)): ?>
<?php $component = $__componentOriginal0d8d3c14ebd2b92d484be47e6c018839; ?>
<?php unset($__componentOriginal0d8d3c14ebd2b92d484be47e6c018839); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Нет уведомлений</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Здесь будут отображаться ваши уведомления.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if($user->notifications->count() > 0): ?>
                        <div class="mt-6 flex justify-end">
                            <form method="POST" action="<?php echo e(route('profile.notifications.read-all')); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Отметить все как прочитанные
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Password Update Card -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="max-w-xl">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex-shrink-0 w-16 h-16 rounded-full bg-green-100 dark:bg-green-900/40 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Обновить пароль</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Убедитесь, что ваш аккаунт использует надежный пароль</p>
                        </div>
                    </div>
                    <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

            <!-- Account Deletion Card -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="max-w-xl">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex-shrink-0 w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/40 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Удалить аккаунт</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Постоянно удалить ваш аккаунт и все данные</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        После удаления ваша учетная запись и все связанные с ней данные будут безвозвратно удалены. 
                        Перед удалением загрузите любые данные или информацию, которую вы хотите сохранить.
                    </p>
                    <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/profile/edit.blade.php ENDPATH**/ ?>