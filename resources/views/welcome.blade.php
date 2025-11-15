<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Maestro7IT — эффективное управление задачами для студентов, преподавателей и разработчиков.">
    <meta name="theme-color" content="#667eea">
    <title>{{ config('app.name', 'Maestro7IT') }}</title>
    
    <!-- Fonts with preload -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/welcome.css', 'resources/js/app.js'])
    
    <style>
        /* Hero section specific styles */
        .hero-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-text {
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Floating animation */
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        .floating-1 { animation-delay: 0s; }
        .floating-2 { animation-delay: 2s; }
        .floating-3 { animation-delay: 4s; }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <div class="h-10 w-10 rounded-lg bg-indigo-600 flex items-center justify-center">
                            <span class="text-white font-bold text-xl">M</span>
                        </div>
                        <span class="ml-3 text-xl font-bold text-gray-900">Maestro7IT</span>
                    </a>
                </div>
                
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Dashboard</a>
                            <a href="{{ route('tasks.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Задачи</a>
                        @else
                            <a href="{{ route('login') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Вход</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Регистрация</a>
                            @endif
                        @endauth
                    </div>
                </div>
                
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" class="md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Dashboard</a>
                    <a href="{{ route('tasks.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Задачи</a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Вход</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">Регистрация</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg text-white py-20 md:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                        <span class="gradient-text">Эффективное управление задачами</span>
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 text-gray-200">
                        Maestro7IT помогает студентам, преподавателям и разработчикам организовывать свои задачи и повышать продуктивность.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        @auth
                            <a href="{{ route('tasks.index') }}" class="px-8 py-4 bg-white text-indigo-600 font-semibold rounded-lg shadow-lg hover:bg-gray-100 transition duration-300 transform hover:-translate-y-1">
                                Перейти к задачам
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-indigo-600 font-semibold rounded-lg shadow-lg hover:bg-gray-100 transition duration-300 transform hover:-translate-y-1">
                                Начать бесплатно
                            </a>
                            <a href="{{ route('login') }}" class="px-8 py-4 bg-transparent border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-indigo-600 transition duration-300 transform hover:-translate-y-1">
                                Войти
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="relative">
                        <div class="absolute -top-6 -left-6 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-30 floating floating-1"></div>
                        <div class="absolute -bottom-6 -right-6 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl opacity-30 floating floating-2"></div>
                        <div class="relative bg-white rounded-2xl shadow-2xl p-6 max-w-md">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Мои задачи</h3>
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">3 активные</span>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <input type="checkbox" class="h-5 w-5 text-indigo-600 rounded">
                                    <span class="ml-3 text-gray-900">Подготовить презентацию</span>
                                </div>
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <input type="checkbox" class="h-5 w-5 text-indigo-600 rounded" checked>
                                    <span class="ml-3 text-gray-400 line-through">Завершить проект</span>
                                </div>
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <input type="checkbox" class="h-5 w-5 text-indigo-600 rounded">
                                    <span class="ml-3 text-gray-900">Сдать отчет</span>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="flex justify-between text-sm text-gray-500">
                                    <span>Прогресс: 33%</span>
                                    <span>3 из 9 задач</span>
                                </div>
                                <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: 33%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Почему выбирают Maestro7IT?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Интуитивно понятный интерфейс и мощные функции для управления задачами</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Интуитивный интерфейс</h3>
                    <p class="text-gray-600">Простой и понятный интерфейс, который позволяет быстро создавать и управлять задачами.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Быстрая синхронизация</h3>
                    <p class="text-gray-600">Все изменения автоматически синхронизируются между устройствами в реальном времени.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Безопасность</h3>
                    <p class="text-gray-600">Все данные надежно защищены и шифруются для обеспечения конфиденциальности.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Отзывы пользователей</h2>
                <p class="text-xl text-gray-600">Что говорят наши пользователи о Maestro7IT</p>
            </div>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-avatar">АС</div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Анна Смирнова</h4>
                    <p class="text-gray-600 italic">"Maestro7IT помог мне организовать учебный процесс. Теперь я никогда не забываю о сроках сдачи заданий!"</p>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-avatar">ИП</div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Иван Петров</h4>
                    <p class="text-gray-600 italic">"Отличный инструмент для управления проектами. Удобный интерфейс и все необходимые функции в одном месте."</p>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-avatar">МК</div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Мария Козлова</h4>
                    <p class="text-gray-600 italic">"Использую Maestro7IT для планирования своих ежедневных задач. Это действительно помогает повысить продуктивность!"</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-indigo-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Готовы начать повышать свою продуктивность?</h2>
            <p class="text-xl text-indigo-100 mb-10 max-w-3xl mx-auto">Присоединяйтесь к тысячам пользователей, которые уже используют Maestro7IT для управления своими задачами.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('tasks.index') }}" class="px-8 py-4 bg-white text-indigo-600 font-semibold rounded-lg shadow-lg hover:bg-gray-100 transition duration-300 transform hover:-translate-y-1">
                        Перейти к задачам
                    </a>
                @else
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-indigo-600 font-semibold rounded-lg shadow-lg hover:bg-gray-100 transition duration-300 transform hover:-translate-y-1">
                        Начать бесплатно
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-transparent border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-indigo-600 transition duration-300 transform hover:-translate-y-1">
                        Войти
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-6">
                        <div class="h-10 w-10 rounded-lg bg-indigo-600 flex items-center justify-center">
                            <span class="text-white font-bold text-xl">M</span>
                        </div>
                        <span class="ml-3 text-2xl font-bold">Maestro7IT</span>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md">Эффективное управление задачами для студентов, преподавателей и разработчиков.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <span class="sr-only">GitHub</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="footer-link-group">
                    <h3 class="text-lg font-semibold mb-4">Продукт</h3>
                    <ul>
                        <li><a href="#" class="hover:text-gray-300 transition">Функции</a></li>
                        <li><a href="#" class="hover:text-gray-300 transition">Тарифы</a></li>
                        <li><a href="#" class="hover:text-gray-300 transition">Интеграции</a></li>
                        <li><a href="#" class="hover:text-gray-300 transition">Обновления</a></li>
                    </ul>
                </div>
                
                <div class="footer-link-group">
                    <h3 class="text-lg font-semibold mb-4">Поддержка</h3>
                    <ul>
                        <li><a href="#" class="hover:text-gray-300 transition">Помощь</a></li>
                        <li><a href="#" class="hover:text-gray-300 transition">Документация</a></li>
                        <li><a href="#" class="hover:text-gray-300 transition">Контакты</a></li>
                        <li><a href="#" class="hover:text-gray-300 transition">Статус</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="mt-16 pt-8 border-t border-gray-800 text-center text-gray-400">
                <p>&copy; 2025 Maestro7IT. Все права защищены.</p>
            </div>
        </div>
    </footer>
</body>
</html>