<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Maestro7IT — эффективное управление задачами для студентов, преподавателей и разработчиков." />
    <title>Maestro7IT — Управляйте задачами эффективно</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom Styles -->
    <style>
        .progress-ring {
            width: 150px;
            height: 75px;
            position: relative;
        }
        .progress-ring svg {
            transform: rotate(-90deg);
            transform-origin: 50% 100%;
        }
        .progress-ring circle {
            stroke-width: 10;
            fill: none;
            stroke-linecap: round;
        }
        .progress-ring .bg {
            stroke: #e5e7eb;
        }
        .progress-ring .fg {
            stroke: #4f46e5;
            transition: stroke-dashoffset 0.5s ease;
        }
        @media (max-width: 640px) {
            .progress-ring {
                width: 120px;
                height: 60px;
            }
            .progress-ring circle {
                stroke-width: 8;
            }
        }
    </style>

    <!-- Tailwind Config (optional customization) -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            500: '#4f46e5',
                            600: '#4338ca',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Header -->
    <header class="bg-white shadow-sm border-b sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex items-center">
            <!-- Logo (max 50x50) -->
            <a href="/" class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                    M7
                </div>
                <span class="text-indigo-600 font-bold text-lg">Maestro7IT</span>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex md:ml-10 space-x-6">
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition">Вход</a>
                <a href="{{ route('register') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition">Регистрация</a>
            </nav>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="md:hidden ml-auto text-gray-600 focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200 px-4 py-3 space-y-2">
            <a href="{{ route('login') }}" class="block text-gray-600 hover:text-indigo-600 font-medium">Вход</a>
            <a href="{{ route('register') }}" class="block text-gray-600 hover:text-indigo-600 font-medium">Регистрация</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16 px-4">
        <div class="container mx-auto text-center max-w-3xl">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Организуйте свои задачи эффективно</h1>
            <p class="text-lg md:text-xl mb-8 opacity-90">
                Maestro7IT — это инструмент для студентов, преподавателей и разработчиков, который помогает управлять задачами, повышать продуктивность и достигать целей быстрее.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-white text-indigo-600 font-semibold py-3 px-7 rounded-lg shadow hover:bg-gray-100 transition duration-200">
                    Начать бесплатно
                </a>
                <a href="{{ route('login') }}" class="bg-transparent border border-white text-white font-semibold py-3 px-7 rounded-lg hover:bg-white/10 transition duration-200">
                    Войти
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 px-4">
        <div class="container mx-auto">
            <h2 class="text-2xl font-bold text-center mb-12">Почему выбирают нас</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $stats = [
                        ['value' => '10K+', 'label' => 'Активных пользователей'],
                        ['value' => '1M+', 'label' => 'Задач выполнено'],
                        ['value' => '99.9%', 'label' => 'Время работы'],
                        ['value' => '24/7', 'label' => 'Поддержка']
                    ];
                @endphp

                @foreach($stats as $stat)
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition text-center">
                        <div class="text-3xl font-bold text-indigo-600 mb-2">{{ $stat['value'] }}</div>
                        <div class="text-gray-600 text-sm">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Progress Tracking -->
    <section class="py-16 px-4 bg-gray-50">
        <div class="container mx-auto text-center max-w-2xl">
            <h2 class="text-2xl font-bold mb-4">Отслеживание прогресса</h2>
            <p class="text-gray-600 mb-10">
                Визуализируйте свой прогресс и отмечайте выполненные задачи для повышения мотивации.
            </p>
            <div class="flex justify-center">
                <div class="progress-ring">
                    <svg width="150" height="75" viewBox="0 0 150 75">
                        <circle class="bg" cx="75" cy="75" r="60" />
                        <circle class="fg" cx="75" cy="75" r="60" stroke-dasharray="377" stroke-dashoffset="188.5" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-xl font-bold text-indigo-600">50%</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 px-4">
        <div class="container mx-auto max-w-4xl">
            <h2 class="text-2xl font-bold text-center mb-12">Отзывы пользователей</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @php
                    $testimonials = [
                        [
                            'name' => 'Иван Сидоров',
                            'role' => 'Фрилансер',
                            'text' => 'Отличный инструмент для управления личными и профессиональными задачами. Интуитивный интерфейс и все необходимые функции в одном месте.',
                            'stars' => 5
                        ],
                        [
                            'name' => 'Мария Козлова',
                            'role' => 'Студентка',
                            'text' => 'Пользуюсь этим приложением для планирования учебы и личных дел. Оно помогает мне не терять фокус и достигать поставленных целей.',
                            'stars' => 5
                        ]
                    ];
                @endphp

                @foreach($testimonials as $testimonial)
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition">
                        <div class="flex items-start space-x-4">
                            <div class="bg-indigo-100 text-indigo-600 w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0">
                                {{ substr($testimonial['name'], 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $testimonial['name'] }}</h3>
                                <p class="text-sm text-gray-500 mb-2">{{ $testimonial['role'] }}</p>
                                <p class="text-gray-700 mb-3">{{ $testimonial['text'] }}</p>
                                <div class="flex">
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="fas fa-star {{ $i < $testimonial['stars'] ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 px-4 bg-indigo-600 text-white">
        <div class="container mx-auto text-center max-w-2xl">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">Готовы начать?</h2>
            <p class="text-lg mb-8 opacity-90">
                Зарегистрируйтесь бесплатно и начните управлять своими задачами уже сегодня.
            </p>
            <a href="{{ route('register') }}" class="inline-block bg-white text-indigo-600 font-semibold py-3 px-8 rounded-lg shadow hover:bg-gray-100 transition duration-200">
                Зарегистрироваться бесплатно
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-10 px-4">
        <div class="container mx-auto">
            <div class="text-center mb-8">
                <div class="text-xl font-bold mb-1">Maestro7IT</div>
                <p class="text-gray-400 text-sm">Организуйте свою жизнь эффективно</p>
            </div>
            <div class="border-t border-gray-800 pt-6 flex flex-col sm:flex-row justify-center gap-5 text-sm">
                <a href="#" class="text-gray-400 hover:text-white transition">О нас</a>
                <a href="#" class="text-gray-400 hover:text-white transition">Контакты</a>
                <a href="#" class="text-gray-400 hover:text-white transition">Политика конфиденциальности</a>
                <a href="#" class="text-gray-400 hover:text-white transition">Условия использования</a>
            </div>
            <div class="mt-8 text-center text-gray-500 text-sm">
                © {{ date('Y') }} Maestro7IT. Все права защищены.
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Script -->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function () {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

</body>
</html>