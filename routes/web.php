<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// Главная → редирект на задачи для авторизованных
Route::get('/', function () {
    return redirect()->route('tasks.index');
})->middleware('auth');

// Dashboard (требует подтверждённой почты)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth', 'verified']);

// Группа защищённых маршрутов
Route::middleware(['auth'])->group(function () {
    // Задачи
    Route::resource('tasks', TaskController::class)->except(['show', 'create', 'edit']);

    // Профиль (Breeze-совместимость)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Аутентификация (Breeze)
require __DIR__.'/auth.php';