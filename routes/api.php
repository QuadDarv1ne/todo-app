<?php

use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\PushController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/statistics', [StatisticsController::class, 'index']);
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/achievements/progress', [AchievementController::class, 'progress']);
    // Push routes
    Route::post('/push/subscribe', [PushController::class, 'subscribe']);
    Route::post('/push/unsubscribe', [PushController::class, 'unsubscribe']);
    Route::post('/push/test', [PushController::class, 'test']);
});

// Публичные роуты для логирования ошибок и производительности клиента
use App\Http\Controllers\ClientLogController;
Route::post('/log-js-error', [ClientLogController::class, 'logJsError']);
Route::post('/log-performance', [ClientLogController::class, 'logPerformance']);
