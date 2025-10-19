<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .feature-card {
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .testimonial-card {
            transition: all 0.3s ease;
        }
        .testimonial-card:hover {
            transform: translateY(-5px);
        }
        .task-preview {
            transition: all 0.3s ease;
        }
        .task-preview:hover {
            background-color: #f8f9fa;
        }
        .stats-card {
            transition: all 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .app-preview {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-radius: 1rem;
        }
        .gradient-text {
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .feature-icon {
            transition: all 0.3s ease;
        }
        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Navigation -->
    @include('layouts.navigation')
    
    <!-- Hero Section -->
    <section class="hero-bg text-white py-20 md:py-32 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-white rounded-full mix-blend-multiply filter blur-xl floating"></div>
            <div class="absolute top-1/3 right-1/4 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl floating animation-delay-2000"></div>
            <div class="absolute bottom-1/4 left-1/3 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl floating animation-delay-4000"></div>
        </div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Организуйте свои задачи <span class="gradient-text">эффективно</span>
            </h1>
            <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto opacity-90">
                Наше приложение TODO поможет вам управлять задачами, повышать продуктивность и достигать целей быстрее.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                @auth
                    <a href="{{ route('tasks.index') }}" 
                       class="bg-white text-indigo-600 hover:bg-gray-100 font-semibold py-3 px-8 rounded-lg transition duration-300 transform hover:-translate-y-1 shadow-lg pulse">
                        Перейти к задачам
                    </a>
                @else
                    <a href="{{ route('register') }}" 
                       class="bg-white text-indigo-600 hover:bg-gray-100 font-semibold py-3 px-8 rounded-lg transition duration-300 transform hover:-translate-y-1 shadow-lg pulse">
                        Начать бесплатно
                    </a>
                    <a href="{{ route('login') }}" 
                       class="bg-transparent border-2 border-white hover:bg-white hover:text-indigo-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                        Войти
                    </a>
                @endauth
            </div>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="py-12 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="stats-card bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow">
                    <div class="text-3xl md:text-4xl font-bold text-indigo-600 dark:text-indigo-400">10K+</div>
                    <div class="text-gray-600 dark:text-gray-300 mt-2">Активных пользователей</div>
                </div>
                <div class="stats-card bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow">
                    <div class="text-3xl md:text-4xl font-bold text-indigo-600 dark:text-indigo-400">1M+</div>
                    <div class="text-gray-600 dark:text-gray-300 mt-2">Задач выполнено</div>
                </div>
                <div class="stats-card bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow">
                    <div class="text-3xl md:text-4xl font-bold text-indigo-600 dark:text-indigo-400">99.9%</div>
                    <div class="text-gray-600 dark:text-gray-300 mt-2">Время работы</div>
                </div>
                <div class="stats-card bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow">
                    <div class="text-3xl md:text-4xl font-bold text-indigo-600 dark:text-indigo-400">24/7</div>
                    <div class="text-gray-600 dark:text-gray-300 mt-2">Поддержка</div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- App Preview Section -->
    <section class="py-20 bg-gray-100 dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Как это работает</h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    Простой и интуитивный интерфейс для управления вашими задачами
                </p>
            </div>
            
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2">
                    <div class="app-preview bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Мои задачи</h3>
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm transition duration-300">
                                + Новая задача
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="task-preview flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <input type="checkbox" class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500">
                                <span class="ml-3 text-gray-800 dark:text-gray-200 line-through">Завершить проект</span>
                                <span class="ml-auto text-sm text-gray-500 dark:text-gray-400">Завершено</span>
                            </div>
                            
                            <div class="task-preview flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow">
                                <input type="checkbox" class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500" checked>
                                <span class="ml-3 text-gray-800 dark:text-gray-200">Подготовить презентацию</span>
                                <span class="ml-auto text-sm text-gray-500 dark:text-gray-400">Сегодня</span>
                            </div>
                            
                            <div class="task-preview flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow">
                                <input type="checkbox" class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500">
                                <span class="ml-3 text-gray-800 dark:text-gray-200">Позвонить клиенту</span>
                                <span class="ml-auto text-sm text-gray-500 dark:text-gray-400">Завтра</span>
                            </div>
                            
                            <div class="task-preview flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow">
                                <input type="checkbox" class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500">
                                <span class="ml-3 text-gray-800 dark:text-gray-200">Обновить документацию</span>
                                <span class="ml-auto text-sm text-gray-500 dark:text-gray-400">25 окт</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="lg:w-1/2">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Управление задачами стало проще</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 h-6 w-6 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mt-1">
                                <svg class="h-4 w-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="ml-3 text-lg text-gray-600 dark:text-gray-300">Создавайте задачи за секунды</p>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 h-6 w-6 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mt-1">
                                <svg class="h-4 w-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="ml-3 text-lg text-gray-600 dark:text-gray-300">Отмечайте выполненные задачи</p>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 h-6 w-6 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mt-1">
                                <svg class="h-4 w-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="ml-3 text-lg text-gray-600 dark:text-gray-300">Устанавливайте сроки выполнения</p>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 h-6 w-6 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mt-1">
                                <svg class="h-4 w-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </div>
                            <p class="ml-3 text-lg text-gray-600 dark:text-gray-300">Перетаскивайте задачи для сортировки</p>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 h-6 w-6 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mt-1">
                                <svg class="h-4 w-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="ml-3 text-lg text-gray-600 dark:text-gray-300">Отслеживайте прогресс выполнения</p>
                        </li>
                    </ul>
                    
                    <div class="mt-8">
                        @auth
                            <a href="{{ route('tasks.index') }}" 
                               class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 transform hover:-translate-y-1">
                                Перейти к задачам
                            </a>
                        @else
                            <a href="{{ route('register') }}" 
                               class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 transform hover:-translate-y-1">
                                Попробовать бесплатно
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="py-20 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Почему выбирают нас</h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    Мощные функции для управления задачами и повышения продуктивности
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-gray-50 dark:bg-gray-700 p-8 rounded-xl shadow-lg transition duration-300">
                    <div class="feature-icon text-indigo-600 dark:text-indigo-400 mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-3 text-center">Управление задачами</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-center">
                        Создавайте, редактируйте и управляйте задачами с легкостью. Назначайте приоритеты и сроки выполнения.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card bg-gray-50 dark:bg-gray-700 p-8 rounded-xl shadow-lg transition duration-300">
                    <div class="feature-icon text-indigo-600 dark:text-indigo-400 mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-3 text-center">Отслеживание прогресса</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-center">
                        Визуализируйте свой прогресс и отмечайте выполненные задачи для повышения мотивации.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card bg-gray-50 dark:bg-gray-700 p-8 rounded-xl shadow-lg transition duration-300">
                    <div class="feature-icon text-indigo-600 dark:text-indigo-400 mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-3 text-center">Безопасность</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-center">
                        Ваши данные надежно защищены. Только вы контролируете доступ к своей информации.
                    </p>
                </div>
                
                <!-- Feature 4 -->
                <div class="feature-card bg-gray-50 dark:bg-gray-700 p-8 rounded-xl shadow-lg transition duration-300">
                    <div class="feature-icon text-indigo-600 dark:text-indigo-400 mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-3 text-center">Drag & Drop</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-center">
                        Перетаскивайте задачи для сортировки и организации в удобном порядке.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="py-20 bg-gray-100 dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Отзывы пользователей</h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    Что говорят наши пользователи о приложении
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="testimonial-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                            <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">АП</span>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800 dark:text-white">Анна Петрова</h4>
                            <p class="text-gray-600 dark:text-gray-400">Менеджер проектов</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 italic">
                        "Это приложение помогло мне организовать рабочие задачи и значительно повысило мою продуктивность. 
                        Теперь я никогда не забываю о важных делах!"
                    </p>
                    <div class="mt-4 flex text-yellow-400">
                        ★★★★★
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="testimonial-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                            <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">ИС</span>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800 dark:text-white">Иван Сидоров</h4>
                            <p class="text-gray-600 dark:text-gray-400">Фрилансер</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 italic">
                        "Отличный инструмент для управления личными и профессиональными задачами. 
                        Интуитивный интерфейс и все необходимые функции в одном месте."
                    </p>
                    <div class="mt-4 flex text-yellow-400">
                        ★★★★★
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="testimonial-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                            <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">МК</span>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800 dark:text-white">Мария Козлова</h4>
                            <p class="text-gray-600 dark:text-gray-400">Студентка</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 italic">
                        "Пользуюсь этим приложением для планирования учебы и личных дел. 
                        Оно помогает мне не терять фокус и достигать поставленных целей."
                    </p>
                    <div class="mt-4 flex text-yellow-400">
                        ★★★★★
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Готовы начать организовывать свою жизнь?</h2>
            <p class="text-xl mb-10 max-w-3xl mx-auto opacity-90">
                Присоединяйтесь к тысячам пользователей, которые уже повысили свою продуктивность
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                @auth
                    <a href="{{ route('tasks.index') }}" 
                       class="bg-white text-indigo-600 hover:bg-gray-100 font-semibold py-3 px-8 rounded-lg transition duration-300 transform hover:-translate-y-1 shadow-lg">
                        Перейти к задачам
                    </a>
                @else
                    <a href="{{ route('register') }}" 
                       class="bg-white text-indigo-600 hover:bg-gray-100 font-semibold py-3 px-8 rounded-lg transition duration-300 transform hover:-translate-y-1 shadow-lg">
                        Зарегистрироваться бесплатно
                    </a>
                @endauth
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <h3 class="text-2xl font-bold">{{ config('app.name', 'TODO App') }}</h3>
                    <p class="mt-2 text-gray-400">Организуйте свою жизнь эффективно</p>
                </div>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="#" class="text-gray-300 hover:text-white transition">О нас</a>
                    <a href="#" class="text-gray-300 hover:text-white transition">Контакты</a>
                    <a href="#" class="text-gray-300 hover:text-white transition">Политика конфиденциальности</a>
                    <a href="#" class="text-gray-300 hover:text-white transition">Условия использования</a>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'TODO App') }}. Все права защищены.</p>
            </div>
        </div>
    </footer>
</body>
</html>