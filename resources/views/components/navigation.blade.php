<nav class="bg-white border-b border-gray-100 shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <!-- Logo & Desktop Nav -->
            <div class="flex items-center gap-4 sm:gap-8">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-2 sm:gap-3">
                    <x-application-logo class="h-8 w-8 sm:h-10 sm:w-10" />
                    <span class="text-lg sm:text-xl font-bold text-indigo-600 hidden sm:inline">Maestro7IT</span>
                    <span class="text-lg font-bold text-indigo-600 sm:hidden">M7</span>
                </a>

                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex gap-8">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="px-1 py-2 text-base font-medium {{ request()->routeIs('dashboard') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-indigo-600' }} transition-colors duration-200">
                            Dashboard
                        </a>
                        <a href="{{ route('tasks.index') }}" 
                           class="px-1 py-2 text-base font-medium {{ request()->routeIs('tasks.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-indigo-600' }} transition-colors duration-200">
                            Задачи
                        </a>
                        <a href="{{ route('achievements.index') }}" 
                           class="px-1 py-2 text-base font-medium {{ request()->routeIs('achievements.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-indigo-600' }} transition-colors duration-200">
                            🎮 Достижения
                        </a>
                        <a href="{{ route('activity-logs.index') }}" 
                           class="px-1 py-2 text-base font-medium {{ request()->routeIs('activity-logs.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-indigo-600' }} transition-colors duration-200">
                            📊 История
                        </a>
                    @endif
                </div>
            </div>

            <!-- Right Section: Auth or User Menu -->
            <div class="flex items-center gap-4">
                @auth
                    <!-- Notifications Bell -->
                    <div class="relative group">
                        <button class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200 relative">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @php
                                $unreadCount = Auth::user()->unreadNotifications->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </button>

                        <!-- Notifications Dropdown -->
                        <div class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 top-full">
                            <div class="p-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Уведомления</h3>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                @forelse(Auth::user()->notifications->take(5) as $notification)
                                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 {{ $notification->read_at ? '' : 'bg-blue-50' }}">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0 mt-0.5">
                                                @if($notification->data['type'] === 'task_limit_approaching')
                                                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900">{{ $notification->data['message'] ?? 'Новое уведомление' }}</p>
                                                <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                            @if(!$notification->read_at)
                                                <div class="flex-shrink-0">
                                                    <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Нет уведомлений</h3>
                                        <p class="mt-1 text-sm text-gray-500">Здесь будут отображаться ваши уведомления.</p>
                                    </div>
                                @endforelse
                            </div>
                            @if(Auth::user()->notifications->count() > 0)
                                <div class="p-3 border-t border-gray-200 text-center">
                                    <a href="{{ route('profile.edit') }}#notifications" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                        Просмотреть все
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Desktop User Menu -->
                    <div class="hidden sm:flex items-center gap-3 relative group">
                        <button class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-lg font-semibold text-indigo-700">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <span class="text-base font-medium text-gray-700 hidden lg:inline">{{ Auth::user()->name }}</span>
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 top-full">
                            <a href="{{ route('profile.edit') }}" class="block px-5 py-3 text-base text-gray-700 hover:bg-gray-50 first:rounded-t-xl transition-colors duration-200">Профиль</a>
                            <a href="{{ route('tasks.index') }}" class="block px-5 py-3 text-base text-gray-700 hover:bg-gray-50 transition-colors duration-200">Мои задачи</a>
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-200">
                                @csrf
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
                @else
                    <!-- Guest Auth Links (Desktop) -->
                    <div class="hidden sm:flex gap-3">
                        <a href="{{ route('login') }}" 
                           class="px-5 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 transition-colors duration-200">
                            Вход
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="px-5 py-2 text-base font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 shadow-md">
                                Регистрация
                            </a>
                        @endif
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  :d="mobileMenuOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
                        </svg>
                    </button>
                @endauth
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden pb-5 space-y-2 mt-2">
            @auth
                <a href="{{ route('dashboard') }}" 
                   class="block px-5 py-4 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }} transition-colors duration-200 text-lg">
                    Dashboard
                </a>
                <a href="{{ route('tasks.index') }}" 
                   class="block px-5 py-4 rounded-lg {{ request()->routeIs('tasks.*') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }} transition-colors duration-200 text-lg">
                    Задачи
                </a>
                <a href="{{ route('achievements.index') }}" 
                   class="block px-5 py-4 rounded-lg {{ request()->routeIs('achievements.*') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }} transition-colors duration-200 text-lg">
                    🎮 Достижения
                </a>
                <a href="{{ route('activity-logs.index') }}" 
                   class="block px-5 py-4 rounded-lg {{ request()->routeIs('activity-logs.*') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }} transition-colors duration-200 text-lg">
                    📊 История
                </a>
                <a href="{{ route('profile.edit') }}" 
                   class="block px-5 py-4 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200 text-lg">
                    Профиль
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-5 py-4 rounded-lg text-red-600 hover:bg-red-50 transition-colors duration-200 text-lg">
                        Выйти
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" 
                   class="block px-5 py-4 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200 text-lg">
                    Вход
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" 
                       class="block px-5 py-4 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-colors duration-200 text-center shadow-md text-lg font-medium">
                        Регистрация
                    </a>
                @endif
            @endauth
        </div>
    </div>
</nav>