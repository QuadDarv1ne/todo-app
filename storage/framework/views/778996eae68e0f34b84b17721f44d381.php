<nav class="bg-white border-b border-gray-100 shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <!-- Logo & Desktop Nav -->
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="<?php echo e(route('welcome')); ?>" class="flex-shrink-0 flex items-center gap-3">
                    <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['class' => 'h-10 w-10']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-10 w-10']); ?>
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
                    <span class="text-xl font-bold text-indigo-600 hidden sm:inline">Maestro7IT</span>
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
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Section: Auth or User Menu -->
            <div class="flex items-center gap-4">
                <?php if(auth()->guard()->check()): ?>
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
        <div x-show="mobileMenuOpen" x-transition class="md:hidden pb-5 space-y-2">
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('dashboard')); ?>" 
                   class="block px-5 py-3 rounded-lg <?php echo e(request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50'); ?> transition-colors duration-200">
                    Dashboard
                </a>
                <a href="<?php echo e(route('tasks.index')); ?>" 
                   class="block px-5 py-3 rounded-lg <?php echo e(request()->routeIs('tasks.*') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50'); ?> transition-colors duration-200">
                    Задачи
                </a>
                <a href="<?php echo e(route('profile.edit')); ?>" 
                   class="block px-5 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Профиль
                </a>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full text-left px-5 py-3 rounded-lg text-red-600 hover:bg-red-50 transition-colors duration-200">
                        Выйти
                    </button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" 
                   class="block px-5 py-3 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Вход
                </a>
                <?php if(Route::has('register')): ?>
                    <a href="<?php echo e(route('register')); ?>" 
                       class="block px-5 py-3 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-colors duration-200 text-center shadow-md">
                        Регистрация
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</nav><?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/components/navigation.blade.php ENDPATH**/ ?>