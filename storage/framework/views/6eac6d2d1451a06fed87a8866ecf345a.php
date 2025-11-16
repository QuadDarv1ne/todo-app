<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo $__env->yieldContent('title', config('app.name', 'Laravel') . ' - Управление задачами'); ?></title>
        
        <!-- SEO Meta Tags -->
        <meta name="description" content="<?php echo $__env->yieldContent('description', 'Эффективное управление задачами и проектами. Создавайте, отслеживайте и завершайте задачи с удобным интерфейсом.'); ?>">
        <meta name="keywords" content="<?php echo $__env->yieldContent('keywords', 'управление задачами, todo, задачи, планирование, продуктивность'); ?>">
        <meta name="author" content="<?php echo e(config('app.name', 'Laravel')); ?>">
        <meta name="robots" content="index, follow">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo e(url()->current()); ?>">
        <meta property="og:title" content="<?php echo $__env->yieldContent('og_title', config('app.name', 'Laravel') . ' - Управление задачами'); ?>">
        <meta property="og:description" content="<?php echo $__env->yieldContent('og_description', 'Эффективное управление задачами и проектами'); ?>">
        <meta property="og:image" content="<?php echo $__env->yieldContent('og_image', asset('images/og-image.jpg')); ?>">
        <meta property="og:locale" content="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
        
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="<?php echo e(url()->current()); ?>">
        <meta name="twitter:title" content="<?php echo $__env->yieldContent('twitter_title', config('app.name', 'Laravel') . ' - Управление задачами'); ?>">
        <meta name="twitter:description" content="<?php echo $__env->yieldContent('twitter_description', 'Эффективное управление задачами и проектами'); ?>">
        <meta name="twitter:image" content="<?php echo $__env->yieldContent('twitter_image', asset('images/og-image.jpg')); ?>">
        
        <!-- Canonical URL -->
        <link rel="canonical" href="<?php echo e(url()->current()); ?>">

        <!-- PWA Manifest -->
        <link rel="manifest" href="/manifest.webmanifest">
        <meta name="theme-color" content="#0ea5e9" media="(prefers-color-scheme: light)">
        <meta name="theme-color" content="#111827" media="(prefers-color-scheme: dark)">
        <?php if(config('push.vapid_public_key')): ?>
            <meta name="vapid-public-key" content="<?php echo e(config('push.vapid_public_key')); ?>">
        <?php endif; ?>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

        <!-- Initial theme loader + react to system changes when no explicit choice -->
        <script>
            (function() {
                const media = window.matchMedia('(prefers-color-scheme: dark)');
                const apply = () => {
                    const stored = localStorage.getItem('theme');
                    const prefersDark = media.matches;
                    if (stored === 'dark' || (!stored && prefersDark)) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                };
                // Apply on load
                apply();
                // React to system theme changes only when user didn't explicitly choose
                media.addEventListener?.('change', () => {
                    if (!localStorage.getItem('theme')) {
                        apply();
                    }
                });
            })();
        </script>

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <?php echo $__env->yieldPushContent('scripts'); ?>
    </head>
    <body class="font-sans antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
            <?php if (isset($component)) { $__componentOriginalf75d29720390c8e1fa3307604849a543 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf75d29720390c8e1fa3307604849a543 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navigation','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navigation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf75d29720390c8e1fa3307604849a543)): ?>
<?php $attributes = $__attributesOriginalf75d29720390c8e1fa3307604849a543; ?>
<?php unset($__attributesOriginalf75d29720390c8e1fa3307604849a543); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf75d29720390c8e1fa3307604849a543)): ?>
<?php $component = $__componentOriginalf75d29720390c8e1fa3307604849a543; ?>
<?php unset($__componentOriginalf75d29720390c8e1fa3307604849a543); ?>
<?php endif; ?>

            <!-- Page Heading -->
            <?php if(isset($header)): ?>
                <header class="bg-white dark:bg-gray-800 shadow transition-colors duration-300">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <?php echo e($header); ?>

                    </div>
                </header>
            <?php endif; ?>

            <!-- Page Content -->
            <main>
                <?php echo e($slot ?? ''); ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
            
            <!-- Live region for accessibility announcements -->
            <div id="aria-live-region" class="sr-only" role="status" aria-live="polite" aria-atomic="true"></div>

            <!-- Toast container -->
            <div id="toast-root" aria-live="polite" aria-atomic="true" class="fixed z-50 inset-0 pointer-events-none flex flex-col items-end gap-3 p-4 sm:p-6">
                <!-- toasts appear here -->
            </div>
        </div>
        
        <!-- Edit Task Modal -->
        <?php if (isset($component)) { $__componentOriginal90bba21216398bc0c4d9b368855cda0b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal90bba21216398bc0c4d9b368855cda0b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.edit-task-modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('edit-task-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal90bba21216398bc0c4d9b368855cda0b)): ?>
<?php $attributes = $__attributesOriginal90bba21216398bc0c4d9b368855cda0b; ?>
<?php unset($__attributesOriginal90bba21216398bc0c4d9b368855cda0b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal90bba21216398bc0c4d9b368855cda0b)): ?>
<?php $component = $__componentOriginal90bba21216398bc0c4d9b368855cda0b; ?>
<?php unset($__componentOriginal90bba21216398bc0c4d9b368855cda0b); ?>
<?php endif; ?>
        
        <?php echo $__env->yieldPushContent('scripts'); ?>

        <!-- Service Worker Registration -->
        <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    // Регистрация успешна
                    // console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                    // Регистрация не удалась
                    // console.warn('ServiceWorker registration failed: ', err);
                });
            });
        }
        </script>
    </body>
</html><?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/layouts/app.blade.php ENDPATH**/ ?>