<nav class="bg-white border-b border-gray-100 shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <!-- Logo & Desktop Nav -->
            <div class="flex items-center gap-4 sm:gap-8">
                <!-- Logo -->
                <a href="<?php echo e(route('home')); ?>" class="flex-shrink-0 flex items-center gap-2 sm:gap-3">
                    <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['class' => 'h-8 w-8 sm:h-10 sm:w-10']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 sm:h-10 sm:w-10']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
                    <span class="text-lg sm:text-xl font-bold text-indigo-600 hidden sm:inline">Maestro7IT</span>
                    <span class="text-lg font-bold text-indigo-600 sm:hidden">M7</span>
                </a>

                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex gap-8">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dashboard')); ?>" 
                           class="px-1 py-2 text-base font-medium <?php echo e(request()->routeIs('dashboard') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-indigo-600'); ?> transition-colors duration-200">
                            Dashboard
                        </a>
                        <a href="<?php echo e(route('tasks.index')); ?>" 
                           class="px-1 py-2 text-base font-medium <?php echo e(request()->routeIs('tasks.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-indigo-600'); ?> transition-colors duration-200">
                            Задачи
                        </a>
                        <a href="<?php echo e(route('achievements.index')); ?>" 
                           class="px-1 py-2 text-base font-medium <?php echo e(request()->routeIs('achievements.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-indigo-600'); ?> transition-colors duration-200">
                            🎮 Достижения
                        </a>
                        <a href="<?php echo e(route('activity-logs.index')); ?>" 
                           class="px-1 py-2 text-base font-medium <?php echo e(request()->routeIs('activity-logs.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-indigo-600'); ?> transition-colors duration-200">
                            📊 История
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Section: Auth or User Menu -->
            <div class="flex items-center gap-4">
                <?php if(auth()->guard()->check()): ?>
                    <!-- Notifications Bell -->
                    <div class="relative group">
                        <button class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200 relative">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <?php
                                $unreadCount = Auth::user()->unreadNotifications->count();
                            ?>
                            <?php if($unreadCount > 0): ?>
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                                    <?php echo e($unreadCount); ?>

                                </span>
                            <?php endif; ?>
                        </button>

                        <!-- Notifications Dropdown -->
                        <div class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 top-full">
                            <div class="p-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Уведомления</h3>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                <?php $__empty_1 = true; $__currentLoopData = Auth::user()->notifications->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 <?php echo e($notification->read_at ? '' : 'bg-blue-50'); ?>">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0 mt-0.5">
                                                <?php if($notification->data['type'] === 'task_limit_approaching'): ?>
                                                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                <?php else: ?>
                                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                <?php endif; ?>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900"><?php echo e($notification->data['message'] ?? 'Новое уведомление'); ?></p>
                                                <p class="text-xs text-gray-500 mt-1"><?php echo e($notification->created_at->diffForHumans()); ?></p>
                                            </div>
                                            <?php if(!$notification->read_at): ?>
                                                <div class="flex-shrink-0">
                                                    <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="p-8 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Нет уведомлений</h3>
                                        <p class="mt-1 text-sm text-gray-500">Здесь будут отображаться ваши уведомления.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if(Auth::user()->notifications->count() > 0): ?>
                                <div class="p-3 border-t border-gray-200 text-center">
                                    <a href="<?php echo e(route('profile.edit')); ?>#notifications" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                        Просмотреть все
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Desktop User Menu -->
                    <div class="hidden sm:flex items-center gap-3 relative group">
                        <button class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-lg font-semibold text-indigo-700"><?php echo e(substr(Auth::user()->name, 0, 1)); ?></span>
                            </div>
                            <span class="text-base font-medium text-gray-700 hidden lg:inline"><?php echo e(Auth::user()->name); ?></span>
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 top-full">
                            <a href="<?php echo e(route('profile.edit')); ?>" class="block px-5 py-3 text-base text-gray-700 hover:bg-gray-50 first:rounded-t-xl transition-colors duration-200">Профиль</a>
                            <a href="<?php echo e(route('tasks.index')); ?>" class="block px-5 py-3 text-base text-gray-700 hover:bg-gray-50 transition-colors duration-200">Мои задачи</a>
                            <form method="POST" action="<?php echo e(route('logout')); ?>" class="border-t border-gray-200">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full text-left px-5 py-3 text-base text-red-600 hover:bg-red-50 last:rounded-b-xl transition-colors duration-200">Выйти</button>
                            </form>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  :d="mobileMenuOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
                        </svg>
                    </button>
                <?php else: ?>
                    <!-- Guest Auth Links (Desktop) -->
                    <div class="hidden sm:flex gap-3">
                        <a href="<?php echo e(route('login')); ?>" 
                           class="px-5 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 transition-colors duration-200">
                            Вход
                        </a>
                        <?php if(Route::has('register')): ?>
                            <a href="<?php echo e(route('register')); ?>" 
                               class="px-5 py-2 text-base font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 shadow-md">
                                Регистрация
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  :d="mobileMenuOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
                        </svg>
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden pb-5 space-y-2 mt-2">
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('dashboard')); ?>" 
                   class="block px-5 py-4 rounded-lg <?php echo e(request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50'); ?> transition-colors duration-200 text-lg">
                    Dashboard
                </a>
                <a href="<?php echo e(route('tasks.index')); ?>" 
                   class="block px-5 py-4 rounded-lg <?php echo e(request()->routeIs('tasks.*') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50'); ?> transition-colors duration-200 text-lg">
                    Задачи
                </a>
                <a href="<?php echo e(route('achievements.index')); ?>" 
                   class="block px-5 py-4 rounded-lg <?php echo e(request()->routeIs('achievements.*') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50'); ?> transition-colors duration-200 text-lg">
                    🎮 Достижения
                </a>
                <a href="<?php echo e(route('activity-logs.index')); ?>" 
                   class="block px-5 py-4 rounded-lg <?php echo e(request()->routeIs('activity-logs.*') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50'); ?> transition-colors duration-200 text-lg">
                    📊 История
                </a>
                <a href="<?php echo e(route('profile.edit')); ?>" 
                   class="block px-5 py-4 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200 text-lg">
                    Профиль
                </a>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full text-left px-5 py-4 rounded-lg text-red-600 hover:bg-red-50 transition-colors duration-200 text-lg">
                        Выйти
                    </button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" 
                   class="block px-5 py-4 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200 text-lg">
                    Вход
                </a>
                <?php if(Route::has('register')): ?>
                    <a href="<?php echo e(route('register')); ?>" 
                       class="block px-5 py-4 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-colors duration-200 text-center shadow-md text-lg font-medium">
                        Регистрация
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</nav><?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/components/navigation.blade.php ENDPATH**/ ?>