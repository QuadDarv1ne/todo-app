<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Maestro7IT — эффективное управление задачами для студентов, преподавателей и разработчиков.">
    <meta name="theme-color" content="#667eea">
    <title>Maestro7IT — Управляйте задачами эффективно</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', system-ui, -apple-system, sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
            line-height: 1.6;
        }

        html {
            scroll-behavior: smooth;
        }

        /* Header */
        header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            font-weight: 700;
            color: #667eea;
            font-size: 1.125rem;
            transition: transform 300ms ease;
        }

        .logo:hover {
            transform: scale(1.02);
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
        }

        nav {
            display: none;
            gap: 2rem;
        }

        @media (min-width: 768px) {
            nav {
                display: flex;
            }
        }

        nav a {
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
            transition: color 300ms ease;
            font-size: 0.875rem;
        }

        nav a:hover {
            color: #667eea;
        }

        .mobile-menu-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: none;
            background: none;
            cursor: pointer;
            color: #6b7280;
            font-size: 1.25rem;
            transition: color 300ms ease;
        }

        @media (min-width: 768px) {
            .mobile-menu-btn {
                display: none;
            }
        }

        .mobile-menu-btn:hover {
            color: #667eea;
        }

        .mobile-menu {
            display: none;
            background: white;
            border-top: 1px solid #e5e7eb;
            padding: 1rem;
        }

        .mobile-menu.show {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .mobile-menu a {
            display: block;
            padding: 0.75rem;
            color: #6b7280;
            text-decoration: none;
            border-radius: 0.375rem;
            transition: all 300ms ease;
        }

        .mobile-menu a:hover {
            background: #f3f4f6;
            color: #667eea;
        }

        /* Hero */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4rem 1rem;
        }

        @media (min-width: 768px) {
            .hero {
                padding: 6rem 1rem;
            }
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .hero h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.1;
        }

        @media (min-width: 768px) {
            .hero h1 {
                font-size: 3rem;
            }
        }

        .hero p {
            font-size: 1rem;
            opacity: 0.95;
            margin-bottom: 2rem;
        }

        @media (min-width: 768px) {
            .hero p {
                font-size: 1.125rem;
            }
        }

        .hero-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            justify-content: center;
        }

        @media (min-width: 640px) {
            .hero-buttons {
                flex-direction: row;
            }
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 300ms ease;
            font-size: 1rem;
        }

        @media (min-width: 768px) {
            .btn {
                padding: 0.875rem 2rem;
            }
        }

        .btn-primary {
            background: white;
            color: #667eea;
        }

        .btn-primary:hover {
            background: #f3f4f6;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Section */
        section {
            max-width: 1280px;
            margin: 0 auto;
            padding: 3rem 1rem;
        }

        @media (min-width: 768px) {
            section {
                padding: 4rem 1rem;
            }
        }

        section h2 {
            font-size: 1.875rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
        }

        @media (min-width: 768px) {
            section h2 {
                font-size: 2.25rem;
            }
        }

        .section-subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
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

        /* Card */
        .card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 300ms ease;
        }

        .card:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .stat-value {
            font-size: 1.875rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
        }

        /* Testimonial */
        .testimonial-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: #e0e7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #667eea;
            flex-shrink: 0;
        }

        .testimonial-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .testimonial-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .testimonial-role {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .stars {
            color: #fbbf24;
            font-size: 0.875rem;
            letter-spacing: 0.125rem;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        /* Footer */
        footer {
            background: #111827;
            color: white;
            padding: 2.5rem 1rem;
            margin-top: auto;
        }

        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
        }

        .footer-content {
            text-align: center;
            margin-bottom: 2rem;
        }

        .footer-brand {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .footer-tagline {
            color: #9ca3af;
            font-size: 0.875rem;
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #374151;
            margin-bottom: 2rem;
        }

        .footer-links a {
            color: #9ca3af;
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 300ms ease;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-copyright {
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
        }

        /* Animations */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: slideUp 0.5s ease-out backwards;
        }

        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.4s; }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <a href="<?php echo e(route('welcome')); ?>" class="logo">
                <div class="logo-icon">M7</div>
                <span>Maestro7IT</span>
            </a>

            <nav>
                <a href="<?php echo e(route('login')); ?>">Вход</a>
                <a href="<?php echo e(route('register')); ?>">Регистрация</a>
            </nav>

            <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Открыть меню">☰</button>
        </div>

        <div class="mobile-menu" id="mobileMenu">
            <a href="<?php echo e(route('login')); ?>">Вход</a>
            <a href="<?php echo e(route('register')); ?>">Регистрация</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Организуйте свои задачи эффективно</h1>
            <p>Maestro7IT поможет вам управлять задачами, повышать продуктивность и достигать целей быстрее.</p>
            <div class="hero-buttons">
                <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">Начать бесплатно</a>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-secondary">Войти</a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section>
        <h2>Почему выбирают нас</h2>
        <div class="grid grid-4">
            <?php $__currentLoopData = [
                ['value' => '10K+', 'label' => 'Активных пользователей'],
                ['value' => '1M+', 'label' => 'Задач выполнено'],
                ['value' => '99.9%', 'label' => 'Время работы'],
                ['value' => '24/7', 'label' => 'Поддержка']
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card">
                    <div class="stat-value"><?php echo e($stat['value']); ?></div>
                    <div class="stat-label"><?php echo e($stat['label']); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <!-- Features Section -->
    <section style="background: #fff;">
        <h2>Основные функции</h2>
        <div class="section-subtitle">Всё что нужно для эффективного управления задачами</div>
        <div class="grid grid-4">
            <?php $__currentLoopData = [
                ['icon' => '✓', 'title' => 'Управление задачами', 'desc' => 'Создавайте и управляйте задачами с легкостью'],
                ['icon' => '◐', 'title' => 'Отслеживание прогресса', 'desc' => 'Видьте прогресс выполнения в реальном времени'],
                ['icon' => '🔒', 'title' => 'Безопасность', 'desc' => 'Ваши данные защищены и надёжны'],
                ['icon' => '↔', 'title' => 'Drag & Drop', 'desc' => 'Перетаскивайте задачи для удобства']
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card">
                    <div style="font-size: 2rem; margin-bottom: 1rem;"><?php echo e($feature['icon']); ?></div>
                    <h3 style="font-weight: 600; margin-bottom: 0.5rem;"><?php echo e($feature['title']); ?></h3>
                    <p style="font-size: 0.875rem; color: #6b7280;"><?php echo e($feature['desc']); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section style="background: #f9fafb;">
        <h2>Отзывы пользователей</h2>
        <div class="grid grid-2">
            <?php $__currentLoopData = [
                ['name' => 'Иван Сидоров', 'role' => 'Фрилансер', 'text' => 'Отличный инструмент для управления задачами. Интуитивный интерфейс и все необходимые функции в одном месте.'],
                ['name' => 'Мария Козлова', 'role' => 'Студентка', 'text' => 'Помогает мне не терять фокус и достигать поставленных целей. Рекомендую всем!']
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar"><?php echo e(substr($testimonial['name'], 0, 1)); ?></div>
                        <div>
                            <div class="testimonial-name"><?php echo e($testimonial['name']); ?></div>
                            <div class="testimonial-role"><?php echo e($testimonial['role']); ?></div>
                        </div>
                    </div>
                    <p style="margin-bottom: 1rem; color: #4b5563;"><?php echo e($testimonial['text']); ?></p>
                    <div class="stars">★★★★★</div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div style="text-align: center; max-width: 600px; margin: 0 auto;">
            <h2 style="color: white; margin-bottom: 1rem;">Готовы начать?</h2>
            <p style="margin-bottom: 2rem; opacity: 0.95;">Зарегистрируйтесь бесплатно и начните управлять своими задачами уже сегодня.</p>
            <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">Зарегистрироваться бесплатно</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-brand">Maestro7IT</div>
                <div class="footer-tagline">Организуйте свою жизнь эффективно</div>
            </div>

            <div class="footer-links">
                <a href="#">О нас</a>
                <a href="#">Контакты</a>
                <a href="#">Политика конфиденциальности</a>
                <a href="#">Условия использования</a>
            </div>

            <div class="footer-copyright">
                © <?php echo e(date('Y')); ?> Maestro7IT. Все права защищены.
            </div>
        </div>
    </footer>

    <script>
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('show');
        });

        // Закрыть меню при клике на ссылку
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('show');
            });
        });
    </script>
</body>
</html><?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/home.blade.php ENDPATH**/ ?>