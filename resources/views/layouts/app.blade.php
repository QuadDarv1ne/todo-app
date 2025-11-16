<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel') . ' - Управление задачами')</title>
        
        <!-- SEO Meta Tags -->
        <meta name="description" content="@yield('description', 'Эффективное управление задачами и проектами. Создавайте, отслеживайте и завершайте задачи с удобным интерфейсом.')">
        <meta name="keywords" content="@yield('keywords', 'управление задачами, todo, задачи, планирование, продуктивность')">
        <meta name="author" content="{{ config('app.name', 'Laravel') }}">
        <meta name="robots" content="index, follow">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="@yield('og_title', config('app.name', 'Laravel') . ' - Управление задачами')">
        <meta property="og:description" content="@yield('og_description', 'Эффективное управление задачами и проектами')">
        <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
        <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
        
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ url()->current() }}">
        <meta name="twitter:title" content="@yield('twitter_title', config('app.name', 'Laravel') . ' - Управление задачами')">
        <meta name="twitter:description" content="@yield('twitter_description', 'Эффективное управление задачами и проектами')">
        <meta name="twitter:image" content="@yield('twitter_image', asset('images/og-image.jpg'))">
        
        <!-- Canonical URL -->
        <link rel="canonical" href="{{ url()->current() }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

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

        @stack('scripts')
    </head>
    <body class="font-sans antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
            <x-navigation />

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow transition-colors duration-300">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot ?? '' }}
                @yield('content')
            </main>
            
            <!-- Live region for accessibility announcements -->
            <div id="aria-live-region" class="sr-only" role="status" aria-live="polite" aria-atomic="true"></div>
        </div>
        
        <!-- Edit Task Modal -->
        <x-edit-task-modal />
        
        @stack('scripts')
    </body>
</html>