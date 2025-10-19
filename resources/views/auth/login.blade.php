<x-guest-layout>
    <div class="flex flex-col items-center mb-8">
        <a href="{{ route('welcome') }}">
            <x-application-logo class="w-20 h-20 fill-current text-indigo-600" />
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-4">Вход в систему</h1>
        <p class="text-gray-600 mt-2">Введите свои учетные данные для доступа к приложению</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="bg-white shadow rounded-lg p-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full rounded-lg" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Пароль')" />

            <x-text-input id="password" class="block mt-1 w-full rounded-lg"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Запомнить меня') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:text-indigo-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Забыли пароль?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 bg-indigo-600 hover:bg-indigo-700">
                {{ __('Войти') }}
            </x-primary-button>
        </div>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Нет аккаунта? 
                <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                    Зарегистрируйтесь здесь
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>