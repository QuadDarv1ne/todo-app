<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Регистрация в Maestro7IT">
    <meta name="theme-color" content="#667eea">
    <title>Регистрация - Maestro7IT</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
            max-width: 500px;
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

        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 2rem;
            gap: 1rem;
        }

        .logo-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 4rem;
            height: 4rem;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transition: transform 300ms ease;
        }

        .logo-link:hover {
            transform: scale(1.05);
        }

        .logo-link svg {
            width: 2rem;
            height: 2rem;
        }

        .header h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
        }

        @media (min-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
        }

        .header p {
            color: #6b7280;
            font-size: 0.875rem;
        }

        @media (min-width: 768px) {
            .header p {
                font-size: 1rem;
            }
        }

        .form-group {
            margin-bottom: 1.25rem;
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

        input.error {
            border-color: #ef4444;
        }

        input.error:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: block;
        }

        .password-requirements {
            background: #f0f9ff;
            border: 1px solid #bfdbfe;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            margin-top: 1rem;
            font-size: 0.75rem;
            color: #1e40af;
        }

        @media (min-width: 768px) {
            .password-requirements {
                font-size: 0.875rem;
            }
        }

        .requirements-list {
            list-style: none;
            margin-top: 0.5rem;
        }

        .requirements-list li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.25rem;
        }

        .requirements-list li::before {
            content: '✓';
            color: #10b981;
            font-weight: bold;
        }

        .form-footer {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1.5rem;
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
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background-color: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background-color: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .auth-link {
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .auth-link a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            transition: color 300ms;
        }

        .auth-link a:hover {
            color: #4f46e5;
            text-decoration: underline;
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

        .alert-success {
            background-color: #dcfce7;
            border: 1px solid #86efac;
            color: #166534;
        }

        @media (max-width: 640px) {
            .card {
                padding: 1.5rem 1rem;
            }

            .header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <!-- Header -->
            <div class="header">
                <a href="{{ route('welcome') }}" class="logo-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </a>
                <div>
                    <h1>Регистрация</h1>
                    <p>Создайте учетную запись для начала работы</p>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- Errors -->
                @if ($errors->any())
                    <div class="alert alert-error">
                        <strong>Ошибка регистрации:</strong>
                        <ul style="list-style: none; margin-top: 0.5rem;">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Полное имя</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        placeholder="Иван Петров"
                        required 
                        autofocus
                        autocomplete="name"
                        class="{{ $errors->has('name') ? 'error' : '' }}"
                    >
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email адрес</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        placeholder="your@email.com"
                        required
                        autocomplete="email"
                        class="{{ $errors->has('email') ? 'error' : '' }}"
                    >
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••"
                        required
                        autocomplete="new-password"
                        class="{{ $errors->has('password') ? 'error' : '' }}"
                    >
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    
                    <div class="password-requirements">
                        <strong>Требования к паролю:</strong>
                        <ul class="requirements-list">
                            <li>Минимум 8 символов</li>
                            <li>Хотя бы одна заглавная буква</li>
                            <li>Хотя бы одна цифра</li>
                        </ul>
                    </div>
                </div>

                <!-- Password Confirmation -->
                <div class="form-group">
                    <label for="password_confirmation">Подтвердите пароль</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="••••••••"
                        required
                        autocomplete="new-password"
                        class="{{ $errors->has('password_confirmation') ? 'error' : '' }}"
                    >
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <span>Зарегистрироваться</span>
                    </button>
                    
                    <div class="auth-link">
                        Уже есть аккаунт? 
                        <a href="{{ route('login') }}">Войдите здесь</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const form = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');

        // Real-time validation
        const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
        
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.classList.contains('error')) {
                    this.classList.remove('error');
                }
            });

            input.addEventListener('blur', function() {
                validateField(this);
            });
        });

        function validateField(field) {
            let isValid = true;

            if (field.type === 'email' && field.value) {
                isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value);
            }

            if (field.name === 'password' && field.value) {
                isValid = field.value.length >= 8;
            }

            if (field.name === 'password_confirmation' && field.value) {
                const password = document.getElementById('password').value;
                isValid = field.value === password;
            }

            if (!isValid && field.value) {
                field.classList.add('error');
            } else {
                field.classList.remove('error');
            }
        }

        // Prevent double submission
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span>Регистрация...</span>';
        });
    </script>
</body>
</html>