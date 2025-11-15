<?php

use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AchievementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/statistics', [StatisticsController::class, 'index']);
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/achievements/progress', [AchievementController::class, 'progress']);
});
