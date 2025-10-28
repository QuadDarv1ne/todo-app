<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware, гарантирующий, что пользователь подтвердил свой email.
 *
 * Применяется к маршрутам, доступным только верифицированным пользователям.
 * Если пользователь не авторизован или не подтвердил email, возвращается JSON-ответ с кодом 409 (Conflict).
 */
class EnsureEmailIsVerified
{
    /**
     * Обрабатывает входящий HTTP-запрос.
     *
     * @param  \Illuminate\Http\Request  $request Входящий запрос
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next Следующий middleware в цепочке
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Проверяем, авторизован ли пользователь и требует ли его модель верификации email
        if (
            $user instanceof MustVerifyEmail &&
            ! $user->hasVerifiedEmail()
        ) {
            return response()->json([
                'message' => __('Your email address is not verified.'),
            ], HttpResponse::HTTP_CONFLICT); // 409
        }

        return $next($request);
    }
}
