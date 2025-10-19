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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --color-primary: #667eea;
            --color-primary-dark: #4f46e5;
            --color-secondary: #764ba2;
            --color-accent: #f093fb;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Instrument Sans', system-ui, -apple-system, sans-serif;
            color: var(--text-primary);
            line-height: 1.6;
        }

        /* Dark mode */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #111827;
                color: #f3f4f6;
            }
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            line-height: 1.2;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Gradients */
        .hero-bg {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
        }

        .gradient-text {
            background: linear-gradient(90deg, var(--color-primary), var(--color-secondary), var(--color-accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Animations */
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        .floating-1 { animation-delay: 0s; }
        .floating-2 { animation-delay: 2s; }
        .floating-3 { animation-delay: 4s; }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            white-space: nowrap;
            text-align: center;
        }

        @media (min-width: 768px) {
            .btn {
                padding: 0.75rem 2rem;
                font-size: 1rem;
            }
        }

        .btn-primary {
            background-color: var(--color-primary-dark);
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.15);
        }

        .btn-secondary {
            background-color: white;
            color: var(--color-primary-dark);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary:hover {
            background-color: #f3f4f6;
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }

        /* Container */
        .container {
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        @media (min-width: 640px) {
            .container {
                max-width: 640px;
            }
        }

        @media (min-width: 768px) {
            .container {
                max-width: 768px;
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }

        @media (min-width: 1024px) {
            .container {
                max-width: 1024px;
            }
        }

        @media (min-width: 1280px) {
            .container {
                max-width: 1280px;
            }
        }

        /* Grid */
        .grid {
            display: grid;
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .grid {
                gap: 2rem;
            }
        }

        .grid-2 {
            grid-template-columns: 1fr;
        }

        @media (min-width: 768px) {
            .grid-2 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .grid-3 {
            grid-template-columns: 1fr;
        }

        @media (min-width: 640px) {
            .grid-3 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .grid-3 {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .grid-4 {
            grid-template-columns: 1fr;
        }

        @media (min-width: 640px) {
            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .grid-4 {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* Section */
        .section {
            padding: 3rem 0;
        }

        @media (min-width: 768px) {
            .section {
                padding: 4rem 0;
            }
        }

        .section-title {
            font-size: 1.875rem;
            margin-bottom: 0.75rem;
            animation: slideInUp 0.6s ease-out;
        }

        @media (min-width: 768px) {
            .section-title {
                font-size: 2.25rem;
            }
        }

        .section-subtitle {
            font-size: 1rem;
            color: var(--text-secondary);
            max-width: 40rem;
            margin: 0 auto;
        }

        @media (min-width: 768px) {
            .section-subtitle {
                font-size: 1.125rem;
            }
        }

        /* Card */
        .card {
            background-color: #f9fafb;
            padding: 1.25rem;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 300ms ease;
        }

        @media (prefers-color-scheme: dark) {
            .card {
                background-color: #1f2937;
            }
        }

        @media (min-width: 768px) {
            .card {
                padding: 1.5rem;
            }
        }

        .card:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        /* Icon wrapper */
        .icon-box {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 9999px;
            background-color: #e0e7ff;
            flex-shrink: 0;
            margin-top: 0.125rem;
        }

        @media (prefers-color-scheme: dark) {
            .icon-box {
                background-color: #312e81;
            }
        }

        @media (min-width: 768px) {
            .icon-box {
                width: 1.5rem;
                height: 1.5rem;
            }
        }

        .icon-box svg {
            width: 0.75rem;
            height: 0.75rem;
            color: var(--color-primary);
        }

        @media (min-width: 768px) {
            .icon-box svg {
                width: 1rem;
                height: 1rem;
            }
        }

        /* Hero section */
        .hero {
            position: relative;
            overflow: hidden;
            min-height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (min-width: 768px) {
            .hero {
                min-height: 700px;
            }
        }

        .hero-content {
            text-align: center;
            color: white;
            position: relative;
            z-index: 10;
        }

        .hero h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
            line-height: 1.1;
        }

        @media (min-width: 768px) {
            .hero h1 {
                font-size: 3rem;
            }
        }

        @media (min-width: 1024px) {
            .hero h1 {
                font-size: 3.5rem;
            }
        }

        .hero p {
            font-size: 1rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            max-width: 42rem;
            margin-left: auto;
            margin-right: auto;
        }

        @media (min-width: 768px) {
            .hero p {
                font-size: 1.25rem;
            }
        }

        .hero-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            justify-content: center;
        }

        @media (min-width: 640px) {
            .hero-buttons {
                flex-direction: row;
                gap: 1rem;
            }
        }

        .hero-bg-elements {
            position: absolute;
            inset: 0;
            opacity: 0.1;
        }

        .hero-bg-circle {
            position: absolute;
            border-radius: 50%;
            mix-blend-mode: multiply;
            filter: blur(40px);
        }

        .hero-bg-circle-1 {
            top: 25%;
            left: 25%;
            width: 12rem;
            height: 12rem;
            background: white;
        }

        @media (min-width: 768px) {
            .hero-bg-circle-1 {
                width: 16rem;
                height: 16rem;
            }
        }

        .hero-bg-circle-2 {
            top: 33%;
            right: 25%;
            width: 12rem;
            height: 12rem;
            background: #818cf8;
        }

        @media (min-width: 768px) {
            .hero-bg-circle-2 {
                width: 18rem;
                height: 18rem;
            }
        }

        .hero-bg-circle-3 {
            bottom: 25%;
            left: 33%;
            width: 12rem;
            height: 12rem;
            background: #c084fc;
        }

        @media (min-width: 768px) {
            .hero-bg-circle-3 {
                width: 20rem;
                height: 20rem;
            }
        }

        /* Stats */
        .stat-card {
            text-align: center;
        }

        .stat-value {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--color-primary);
        }

        @media (min-width: 768px) {
            .stat-value {
                font-size: 2rem;
            }
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-top: 0.5rem;
        }

        @media (min-width: 768px) {
            .stat-label {
                font-size: 1rem;
            }
        }

        /* Features */
        .feature-icon {
            width: 3rem;
            height: 3rem;
            margin: 0 auto 1rem;
            color: var(--color-primary);
        }

        @media (min-width: 768px) {
            .feature-icon {
                width: 3.5rem;
                height: 3.5rem;
            }
        }

        /* Testimonial */
        .testimonial-avatar {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            background-color: #e0e7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--color-primary);
            flex-shrink: 0;
        }

        @media (prefers-color-scheme: dark) {
            .testimonial-avatar {
                background-color: #312e81;
            }
        }

        @media (min-width: 768px) {
            .testimonial-avatar {
                width: 3.5rem;
                height: 3.5rem;
            }
        }

        .testimonial-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .testimonial-name {
            font-weight: 700;
            font-size: 0.875rem;
        }

        @media (min-width: 768px) {
            .testimonial-name {
                font-size: 1rem;
            }
        }

        .testimonial-role {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        @media (min-width: 768px) {
            .testimonial-role {
                font-size: 0.875rem;
            }
        }

        /* Task preview */
        .task-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
        }

        @media (min-width: 768px) {
            .task-item {
                padding: 1rem;
            }
        }

        .task-item input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            cursor: pointer;
        }

        @media (min-width: 768px) {
            .task-item input[type="checkbox"] {
                width: 1.25rem;
                height: 1.25rem;
            }
        }

        .task-text {
            flex: 1;
            font-size: 0.875rem;
        }

        @media (min-width: 768px) {
            .task-text {
                font-size: 1rem;
            }
        }

        .task-date {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        @media (min-width: 768px) {
            .task-date {
                font-size: 0.875rem;
            }
        }

        /* Responsive padding */
        .px-safe {
            padding-left: max(1rem, env(safe-area-inset-left));
            padding-right: max(1rem, env(safe-area-inset-right));
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero hero-bg">
        <div class="hero-bg-elements">
            <div class="hero-bg-circle hero-bg-circle-1 floating floating-1"></div>
            <div class="hero-bg-circle hero-bg-circle-2 floating floating-2"></div>
            <div class="hero-bg-circle hero-bg-circle-3 floating floating-3"></div>
        </div>

        <div class="container hero-content">
            <h1>Организуйте свои задачи <span class="gradient-text">эффективно</span></h1>
            <p>Maestro7IT поможет вам управлять задачами, повышать продуктивность и достигать целей быстрее.</p>
            <div class="hero-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Перейти в Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary">Попробовать бесплатно</a>
                    <a href="{{ route('login') }}" class="btn btn-secondary">Вход</a>
                @endauth
            </div>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="section" style="background-color: #fff;">
        <div class="container">
            <div class="grid grid-4">
                @foreach([
                    ['value' => '10K+', 'label' => 'Активных пользователей'],
                    ['value' => '1M+', 'label' => 'Задач выполнено'],
                    ['value' => '99.9%', 'label' => 'Время работы'],
                    ['value' => '24/7', 'label' => 'Поддержка']
                ] as $stat)
                    <div class="card stat-card">
                        <div class="stat-value">{{ $stat['value'] }}</div>
                        <div class="stat-label">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- App Preview Section -->
    <section class="section">
        <div class="container">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h2 class="section-title">Как это работает</h2>
                <p class="section-subtitle">Простой и интуитивный интерфейс для управления вашими задачами</p>
            </div>
            
            <div class="grid grid-2" style="align-items: start;">
                <!-- Preview -->
                <div>
                    <div class="card">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; gap: 1rem;">
                            <h3 style="font-size: 1.125rem;">Мои задачи</h3>
                            <button class="btn btn-primary" style="white-space: nowrap;">+ Новая</button>
                        </div>
                        
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            @foreach([
                                ['text' => 'Завершить проект', 'date' => 'Завершено', 'completed' => true],
                                ['text' => 'Подготовить презентацию', 'date' => 'Сегодня', 'completed' => true],
                                ['text' => 'Позвонить клиенту', 'date' => 'Завтра', 'completed' => false],
                                ['text' => 'Обновить документацию', 'date' => '25 окт', 'completed' => false]
                            ] as $task)
                                <div class="task-item" style="background-color: {{ $task['completed'] ? '#f3f4f6' : '#fff' }}; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                    <input type="checkbox" {{ $task['completed'] ? 'checked' : '' }} class="task-checkbox">
                                    <span class="task-text" style="{{ $task['completed'] ? 'text-decoration: line-through; opacity: 0.6;' : '' }}">{{ $task['text'] }}</span>
                                    <span class="task-date">{{ $task['date'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Features List -->
                <div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1.5rem; font-weight: 700;">Управление задачами стало проще</h3>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 1rem;">
                        @foreach([
                            'Создавайте задачи за секунды',
                            'Отмечайте выполненные задачи',
                            'Устанавливайте сроки выполнения',
                            'Перетаскивайте задачи для сортировки',
                            'Отслеживайте прогресс выполнения'
                        ] as $feature)
                            <li style="display: flex; gap: 0.75rem; align-items: flex-start;">
                                <div class="icon-box">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span style="font-size: 1rem;">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                    
                    <div style="margin-top: 2rem;">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">Перейти в Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary">Попробовать бесплатно</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="section" style="background-color: #fff;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h2 class="section-title">Почему выбирают нас</h2>
                <p class="section-subtitle">Мощные функции для управления задачами и повышения продуктивности</p>
            </div>
            
            <div class="grid grid-4">
                @foreach([
                    ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'title' => 'Управление задачами', 'desc' => 'Создавайте, редактируйте и управляйте задачами с легкостью.'],
                    ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Отслеживание прогресса', 'desc' => 'Визуализируйте свой прогресс и отмечайте выполненные задачи.'],
                    ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'title' => 'Безопасность', 'desc' => 'Ваши данные надежно защищены и под вашим контролем.'],
                    ['icon' => 'M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4', 'title' => 'Drag & Drop', 'desc' => 'Перетаскивайте задачи для удобной сортировки.']
                ] as $feature)
                    <div class="card" style="text-align: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="feature-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $feature['icon'] }}" />
                        </svg>
                        <h3 style="font-size: 1.125rem; margin-bottom: 0.5rem;">{{ $feature['title'] }}</h3>
                        <p style="font-size: 0.875rem; color: var(--text-secondary);">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="section">
        <div class="container">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h2 class="section-title">Отзывы пользователей</h2>
                <p class="section-subtitle">Что говорят наши пользователи о приложении</p>
            </div>
            
            <div class="grid grid-3">
                @foreach([
                    ['initials' => 'АП', 'name' => 'Анна Петрова', 'role' => 'Менеджер проектов', 'text' => 'Это приложение помогло мне организовать рабочие задачи и значительно повысило мою продуктивность.'],
                    ['initials' => 'ИС', 'name' => 'Иван Сидоров', 'role' => 'Фрилансер', 'text' => 'Отличный инструмент для управления личными и профессиональными задачами. Всё в одном месте.'],
                    ['initials' => 'МК', 'name' => 'Мария Козлова', 'role' => 'Студентка', 'text' => 'Пользуюсь для планирования учебы. Помогает не терять фокус и достигать поставленных целей.']
                ] as $testimonial)
                    <div class="card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">{{ $testimonial['initials'] }}</div>
                            <div>
                                <div class="testimonial-name">{{ $testimonial['name'] }}</div>
                                <div class="testimonial-role">{{ $testimonial['role'] }}</div>
                            </div>
                        </div>
                        <p style="font-style: italic; margin-bottom: 1rem; font-size: 0.875rem;">"{{ $testimonial['text'] }}"</p>
                        <div style="font-size: 1.125rem;">★★★★★</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="section" style="background: linear-gradient(to right, #667eea, #764ba2); color: white;">
        <div class="container" style="text-align: center;">
            <h2 class="section-title" style="color: white; margin-bottom: 1rem;">Готовы начать организовывать свою жизнь?</h2>
            <p style="margin-bottom: 2rem; opacity: 0.95; font-size: 1rem;">Присоединяйтесь к тысячам пользователей, которые уже повысили свою продуктивность</p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Перейти в Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-secondary">Зарегистрироваться бесплатно</a>
            @endauth
        </div>
    </section>
    
    <!-- Footer -->
    <footer style="background-color: #1f2937; color: white; padding: 2.5rem 0;">
        <div class="container">
            <div style="display: flex; flex-direction: column; gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 700;">{{ config('app.name', 'TODO App') }}</h3>
                    <p style="margin-top: 0.5rem; color: #9ca3af; font-size: 0.875rem;">Организуйте свою жизнь эффективно</p>
                </div>
                <nav style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: center; font-size: 0.875rem;">
                    @foreach(['О нас', 'Контакты', 'Политика', 'Условия'] as $link)
                        <a href="#" style="color: #d1d5db; transition: color 300ms;">{{ $link }}</a>
                    @endforeach
                </nav>
            </div>
            <div style="padding-top: 1.5rem; border-top: 1px solid #374151; text-align: center; color: #9ca3af; font-size: 0.875rem;">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'TODO App') }}. Все права защищены.</p>
            </div>
        </div>
    </footer>
</body>
</html>