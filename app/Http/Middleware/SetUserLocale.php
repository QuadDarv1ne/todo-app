<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

/**
 * Устанавливает локаль приложения на основе настроек авторизованного пользователя.
 *
 * Работает только для аутентифицированных пользователей.
 * Если пользователь не авторизован — используется локаль по умолчанию из config/app.php.
 */
class SetUserLocale
{
    /**
     * Обрабатывает входящий запрос.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($user = $request->user()) {
            // Убедитесь, что локаль безопасна (защита от инъекций)
            $allowedLocales = ['en', 'ru', 'es']; // ← настройте под ваш проект
            $locale = in_array($user->locale, $allowedLocales)
                ? $user->locale
                : config('app.locale');

            App::setLocale($locale);
        }

        return $next($request);
    }
}