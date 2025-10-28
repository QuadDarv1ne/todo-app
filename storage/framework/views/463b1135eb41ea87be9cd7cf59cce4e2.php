<nav class="bg-white border-b border-gray-100 shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <!-- Logo & Desktop Nav -->
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="<?php echo e(route('welcome')); ?>" class="flex-shrink-0 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="text-lg font-bold text-indigo-600 hidden sm:inline">Maestro7IT</span>
                </a>

                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex gap-6">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dashboard')); ?>" 
                           class="px-1 py-2 text-sm font-medium <?php echo e(request()->routeIs('dashboard') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-gray-900'); ?> transition">
                            Dashboard
                        </a>
                        <a href="<?php echo e(route('tasks.index')); ?>" 
                           class="px-1 py-2 text-sm font-medium <?php echo e(request()->routeIs('tasks.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-gray-900'); ?> transition">
                            Задачи
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Section: Auth or User Menu -->
            <div class="flex items-center gap-4">
                <?php if(auth()->guard()->check()): ?>
                    <!-- Desktop User Menu -->
                    <div class="hidden sm:flex items-center gap-2 relative group">
                        <button class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-sm font-semibold text-indigo-700"><?php echo e(substr(Auth::user()->name, 0, 1)); ?></span>
                            </div>
                            <span class="text-sm font-medium text-gray-700 hidden lg:inline"><?php echo e(Auth::user()->name); ?></span>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-0 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 top-full">
                            <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 first:rounded-t-lg">Профиль</a>
                            <a href="<?php echo e(route('tasks.index')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Мои задачи</a>
                            <form method="POST" action="<?php echo e(route('logout')); ?>" class="border-t border-gray-200">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 last:rounded-b-lg">Выйти</button>
                            </form>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  :d="mobileMenuOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
                        </svg>
                    </button>
                <?php else: ?>
                    <!-- Guest Auth Links (Desktop) -->
                    <div class="hidden sm:flex gap-3">
                        <a href="<?php echo e(route('login')); ?>" 
                           class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition">
                            Вход
                        </a>
                        <?php if(Route::has('register')): ?>
                            <a href="<?php echo e(route('register')); ?>" 
                               class="px-4 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                Регистрация
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  :d="mobileMenuOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
                        </svg>
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden pb-4 space-y-2">
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('dashboard')); ?>" 
                   class="block px-4 py-2 rounded-lg <?php echo e(request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50'); ?> transition">
                    Dashboard
                </a>
                <a href="<?php echo e(route('tasks.index')); ?>" 
                   class="block px-4 py-2 rounded-lg <?php echo e(request()->routeIs('tasks.*') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50'); ?> transition">
                    Задачи
                </a>
                <a href="<?php echo e(route('profile.edit')); ?>" 
                   class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Профиль
                </a>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full text-left px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 transition">
                        Выйти
                    </button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" 
                   class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Вход
                </a>
                <?php if(Route::has('register')): ?>
                    <a href="<?php echo e(route('register')); ?>" 
                       class="block px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition text-center">
                        Регистрация
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</nav><?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>