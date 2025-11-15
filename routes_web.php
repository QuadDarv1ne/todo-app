<?php

/**
 * Web Routes для модуля донатов
 * 
 * Определяет маршруты для работы с донатами и их статистикой.
 * Все маршруты требуют аутентификации пользователя.
 * 
 * Маршруты:
 * - GET  /donations/my          - страница "Мои донаты" с полной статистикой
 * - POST /donations             - создание нового доната
 * - GET  /api/donations/stats   - API эндпоинт для получения статистики в JSON
 * 
 * Middleware:
 * - auth - требует авторизованного пользователя
 * 
 * Использование:
 * - route('donations.my') - ссылка на страницу донатов
 * - route('donations.store') - отправка формы создания доната
 * - route('donations.api.stats') - AJAX запросы для динамического обновления
 */

use App\Http\Controllers\DonationController;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', function () {
    return view('welcome');
});

// Маршруты для донатов (требуют аутентификации)
Route::middleware(['auth'])->group(function () {
    // Страница "Мои донаты"
    Route::get('/donations/my', [DonationController::class, 'myDonations'])
        ->name('donations.my');
    
    // Создание нового доната
    Route::post('/donations', [DonationController::class, 'store'])
        ->name('donations.store');
    
    // API для получения статистики
    Route::get('/api/donations/stats', [DonationController::class, 'apiStats'])
        ->name('donations.api.stats');
});