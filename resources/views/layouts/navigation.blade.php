<nav class="bg-white border-b border-gray-100 shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <!-- Logo & Desktop Nav -->
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="text-lg font-bold text-indigo-600 hidden sm:inline">Maestro7IT</span>
                </a>

                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex gap-6">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="px-1 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-gray-900' }} transition">
                            Dashboard
                        </a>
                        <a href="{{ route('tasks.index') }}" 
                           class="px-1 py-2 text-sm font-medium {{ request()->routeIs('tasks.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-gray-900' }} transition">
                            Задачи
                        </a>
                        <a href="{{ route('statistics.show') }}" 
                           class="px-1 py-2 text-sm font-medium {{ request()->routeIs('statistics.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-gray-900' }} transition">
                            Статистика
                        </a>
                        <a href="{{ route('templates.index') }}" 
                           class="px-1 py-2 text-sm font-medium {{ request()->routeIs('templates.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-gray-900' }} transition">
                            Шаблоны
                        </a>
                        <a href="{{ route('donations.my') }}" 
                           class="px-1 py-2 text-sm font-medium {{ request()->routeIs('donations.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-gray-900' }} transition">
                            Донаты
                        </a>
                    @endif
                </div>
            </div>

            <!-- Right Section: Auth or User Menu -->
            <div class="flex items-center gap-4">
                @auth
                    <!-- Notification Bell Icon -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="relative p-2 rounded-lg hover:bg-gray-100 transition">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50" x-cloak>
                            <div class="p-4 border-b border-gray-200">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-sm font-semibold text-gray-900">Уведомления</h3>
                                    @if(Auth::user()->unreadNotifications->count() > 0)
                                        <form method="POST" action="{{ route('notifications.readAll') }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-xs text-blue-600 hover:text-blue-800">
                                                Прочитать все
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="max-h-96 overflow-y-auto">
                                @forelse(Auth::user()->unreadNotifications->take(5) as $notification)
                                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 {{ !$notification->read_at ? 'bg-blue-50' : '' }}">
                                        <p class="text-sm font-medium text-gray-900">{{ $notification->data['task_title'] ?? 'Уведомление' }}</p>
                                        <p class="text-xs text-gray-600 mt-1">{{ $notification->data['message'] ?? '' }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                @empty
                                    <div class="p-6 text-center text-gray-500 text-sm">
                                        Нет новых уведомлений
                                    </div>
                                @endforelse
                            </div>
                            
                            <div class="p-3 border-t border-gray-200 text-center">
                                <a href="{{ route('notifications.show') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    Все уведомления
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop User Menu -->
                    <div class="hidden sm:flex items-center gap-2 relative group">
                        <button class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-sm font-semibold text-indigo-700">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <span class="text-sm font-medium text-gray-700 hidden lg:inline">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-0 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 top-full">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 first:rounded-t-lg">Профиль</a>
                            <a href="{{ route('tasks.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Мои задачи</a>
                            <a href="{{ route('templates.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Шаблоны</a>
                            <a href="{{ route('donations.my') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Мои донаты</a>
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-200">
                                @csrf
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
                @else
                    <!-- Guest Auth Links (Desktop) -->
                    <div class="hidden sm:flex gap-3">
                        <a href="{{ route('login') }}" 
                           class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition">
                            Вход
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="px-4 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                Регистрация
                            </a>
                        @endif
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  :d="mobileMenuOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
                        </svg>
                    </button>
                @endauth
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden pb-4 space-y-2">
            @auth
                <a href="{{ route('dashboard') }}" 
                   class="block px-4 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }} transition">
                    Dashboard
                </a>
                <a href="{{ route('tasks.index') }}" 
                   class="block px-4 py-2 rounded-lg {{ request()->routeIs('tasks.*') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }} transition">
                    Задачи
                </a>
                <a href="{{ route('statistics.show') }}" 
                   class="block px-4 py-2 rounded-lg {{ request()->routeIs('statistics.*') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }} transition">
                    Статистика
                </a>
                <a href="{{ route('templates.index') }}" 
                   class="block px-4 py-2 rounded-lg {{ request()->routeIs('templates.*') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }} transition">
                    Шаблоны
                </a>
                <a href="{{ route('donations.my') }}" 
                   class="block px-4 py-2 rounded-lg {{ request()->routeIs('donations.*') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-gray-700 hover:bg-gray-50' }} transition">
                    Донаты
                </a>
                <a href="{{ route('profile.edit') }}" 
                   class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Профиль
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 transition">
                        Выйти
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" 
                   class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Вход
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" 
                       class="block px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition text-center">
                        Регистрация
                    </a>
                @endif
            @endauth
        </div>
    </div>
</nav>