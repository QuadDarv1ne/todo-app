<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Maestro7IT — вход и регистрация">
    <meta name="theme-color" content="#667eea">
    <title>{{ $title ?? 'Maestro7IT' }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .container {
            width: 100%;
            max-width: 450px;
        }

        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
            padding: 2rem 1.5rem;
            animation: slideUp 0.4s ease-out;
        }

        @media (min-width: 768px) {
            .card {
                padding: 3rem 2.5rem;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            gap: 0.75rem;
        }

        .logo svg {
            width: 2.5rem;
            height: 2.5rem;
            color: #667eea;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
        }

        .tabs {
            display: flex;
            gap: 0;
            margin-bottom: 2rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .tab {
            flex: 1;
            padding: 1rem;
            text-align: center;
            font-weight: 600;
            color: #9ca3af;
            cursor: pointer;
            transition: all 300ms ease;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            position: relative;
            background: none;
            border: none;
            outline: none;
        }

        .tab:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .tab.active {
            color: #667eea;
            border-bottom-color: #667eea;
            background: rgba(102, 126, 234, 0.08);
        }

        .tab-content {
            display: none;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .tab-content.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
            animation: slideInUp 0.3s ease-out;
        }

        @keyframes slideInUp {
            from { 
                opacity: 0; 
                transform: translateY(15px);
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

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
            font-size: 0.875rem;
        }

        input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-family: inherit;
            font-size: 1rem;
            transition: all 300ms ease;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        input::placeholder {
            color: #d1d5db;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        input.error {
            border-color: #ef4444;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        input[type="checkbox"] {
            width: 1.125rem;
            height: 1.125rem;
            cursor: pointer;
            accent-color: #667eea;
        }

        .checkbox-label {
            margin: 0;
            cursor: pointer;
            font-size: 0.875rem;
            color: #374151;
        }

        .forgot-link {
            display: inline-block;
            margin-top: 0.5rem;
            color: #667eea;
            font-size: 0.875rem;
            transition: color 300ms;
        }

        .forgot-link:hover {
            color: #4f46e5;
            text-decoration: underline;
        }

        .btn {
            width: 100%;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 300ms ease;
            margin-top: 1rem;
            background-color: #667eea;
            color: white;
        }

        .btn:hover {
            background-color: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(102, 126, 234, 0.3);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            animation: slideUp 0.3s ease-out;
        }

        .alert-error {
            background-color: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;
        }

        .footer-text {
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 1.5rem;
        }

        .footer-link {
            color: #667eea;
            cursor: pointer;
            font-weight: 600;
            transition: color 300ms;
        }

        .footer-link:hover {
            color: #4f46e5;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            color: #667eea;
            font-size: 0.875rem;
            text-decoration: none;
            transition: color 300ms;
        }

        .back-link:hover {
            color: #4f46e5;
        }

        .back-link svg {
            width: 1rem;
            height: 1rem;
        }

        @media (max-width: 640px) {
            .card {
                padding: 1.5rem 1rem;
            }

            .tab {
                padding: 0.75rem;
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <!-- Back Link -->
            <a href="{{ route('home') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                На главную
            </a>

            <!-- Logo -->
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <span class="logo-text">Maestro7IT</span>
            </div>

            <!-- Tabs -->
            <div class="tabs">
                <button class="tab {{ request()->routeIs('login') && !old('name') ? 'active' : '' }}" onclick="switchTab('login', event)" data-tab="login">Вход</button>
                <button class="tab {{ old('name') ? 'active' : '' }}" onclick="switchTab('register', event)" data-tab="register">Регистрация</button>
            </div>

            <!-- Login Tab -->
            <div id="login" class="tab-content {{ request()->routeIs('login') && !old('name') ? 'active' : '' }}">
                @if ($errors->any())
                    <div class="alert alert-error">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                               placeholder="your@email.com" required autofocus>
                        @error('email')
                            <div class="error-message show">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" id="password" name="password" 
                               placeholder="••••••••" required>
                        @error('password')
                            <div class="error-message show">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember" class="checkbox-label">Запомнить меня</label>
                        </div>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Забыли пароль?</a>
                    @endif

                    <button type="submit" class="btn">Вход</button>
                </form>
            </div>

            <!-- Register Tab -->
            <div id="register" class="tab-content {{ old('name') ? 'active' : '' }}">
                @if ($errors->any() && old('name'))
                    <div class="alert alert-error">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                               placeholder="Ваше имя" required autofocus>
                        @error('name')
                            <div class="error-message show">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email-reg">Email</label>
                        <input type="email" id="email-reg" name="email" value="{{ old('email') }}" 
                               placeholder="your@email.com" required>
                        @error('email')
                            <div class="error-message show">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-reg">Пароль</label>
                        <input type="password" id="password-reg" name="password" 
                               placeholder="••••••••" required>
                        @error('password')
                            <div class="error-message show">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Подтверждение пароля</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn">Зарегистрироваться</button>
                </form>
            </div>

            <!-- Footer -->
            <div class="footer-text">
                <span id="auth-footer"></span>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName, event) {
            if (event) {
                event.preventDefault();
            }

            // Remove active class from all tabs and content
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });

            // Add active class to selected tab and content
            const tabContent = document.getElementById(tabName);
            const tabButton = document.querySelector(`[data-tab="${tabName}"]`);
            
            if (tabContent) tabContent.classList.add('active');
            if (tabButton) tabButton.classList.add('active');

            // Update footer text
            updateFooterText(tabName);
            
            // Focus first input in active tab
            setTimeout(() => {
                const firstInput = tabContent?.querySelector('input:not([type="checkbox"])');
                if (firstInput) firstInput.focus();
            }, 100);
        }

        function updateFooterText(tabName) {
            const footer = document.getElementById('auth-footer');
            if (!footer) return;
            
            if (tabName === 'login') {
                footer.innerHTML = 'Нет аккаунта? <span class="footer-link" onclick="switchTab(\'register\')">Зарегистрируйтесь</span>';
            } else {
                footer.innerHTML = 'Уже есть аккаунт? <span class="footer-link" onclick="switchTab(\'login\')">Войдите</span>';
            }
        }

        // Form validation helpers
        function validateEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        function validatePassword(password) {
            return password.length >= 8;
        }

        function showFieldError(input, message) {
            input.classList.add('error');
            let errorMsg = input.parentElement.querySelector('.error-message');
            if (!errorMsg) {
                errorMsg = document.createElement('div');
                errorMsg.className = 'error-message show';
                input.parentElement.appendChild(errorMsg);
            }
            errorMsg.textContent = message;
            errorMsg.classList.add('show');
        }

        function clearFieldError(input) {
            input.classList.remove('error');
            const errorMsg = input.parentElement.querySelector('.error-message');
            if (errorMsg) {
                errorMsg.classList.remove('show');
            }
        }

        // Real-time validation for all inputs
        document.querySelectorAll('input').forEach(input => {
            // Clear error on input
            input.addEventListener('input', function() {
                clearFieldError(this);
            });

            // Validate on blur
            input.addEventListener('blur', function() {
                if (!this.value) return;

                if (this.type === 'email') {
                    if (!validateEmail(this.value)) {
                        showFieldError(this, 'Введите корректный email адрес');
                    }
                } else if (this.type === 'password' && this.name === 'password') {
                    if (!validatePassword(this.value)) {
                        showFieldError(this, 'Пароль должен содержать минимум 8 символов');
                    }
                } else if (this.name === 'password_confirmation') {
                    const passwordField = document.getElementById('password-reg');
                    if (passwordField && this.value !== passwordField.value) {
                        showFieldError(this, 'Пароли не совпадают');
                    }
                }
            });
        });

        // Password confirmation real-time check
        const passwordConfirm = document.getElementById('password_confirmation');
        if (passwordConfirm) {
            passwordConfirm.addEventListener('input', function() {
                const passwordField = document.getElementById('password-reg');
                if (passwordField && this.value && passwordField.value) {
                    if (this.value === passwordField.value) {
                        clearFieldError(this);
                    } else {
                        showFieldError(this, 'Пароли не совпадают');
                    }
                }
            });
        }

        // Form submission handling
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    // Disable button and show loading state
                    submitBtn.disabled = true;
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<svg class="h-5 w-5 animate-spin inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Загрузка...';
                    
                    // Re-enable after 3 seconds to prevent permanent lock
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 3000);
                }
            });
        });

        // Initialize correct tab on page load
        document.addEventListener('DOMContentLoaded', function() {
            const hasRegistrationData = {{ old('name') ? 'true' : 'false' }};
            const hasLoginErrors = {{ ($errors->has('email') || $errors->has('password')) && !old('name') ? 'true' : 'false' }};
            
            if (hasRegistrationData) {
                switchTab('register');
            } else if (hasLoginErrors) {
                switchTab('login');
            } else {
                // Default to login tab
                switchTab('login');
            }
        });
    </script>
</body>
</html>