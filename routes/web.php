<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DonationController;

// Главная страница - welcome
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('home');
})->name('welcome');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth', 'verified']);

// Защищённые маршруты
Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');

    // Профиль
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Маршруты для донатов
    Route::get('/donations/my', [DonationController::class, 'myDonations'])->name('donations.my');
    Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
    Route::get('/api/donations/stats', [DonationController::class, 'apiStats'])->name('donations.api.stats');
});

require __DIR__.'/auth.php';