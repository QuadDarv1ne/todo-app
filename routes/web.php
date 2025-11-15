<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');
    
    // Экспорт задач
    Route::get('/tasks/export/json', [TaskController::class, 'exportJson'])->name('tasks.export.json');
    Route::get('/tasks/export/csv', [TaskController::class, 'exportCsv'])->name('tasks.export.csv');
    Route::get('/tasks/export/pdf', [TaskController::class, 'exportPdf'])->name('tasks.export.pdf');
    Route::get('/reports/tasks', [TaskController::class, 'generateReport'])->name('tasks.report');

    // Теги
    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
    Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
    Route::patch('/tags/{tag}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
    Route::post('/tags/attach', [TagController::class, 'attach'])->name('tags.attach');
    Route::post('/tags/detach', [TagController::class, 'detach'])->name('tags.detach');

    // Статистика
    Route::get('/statistics', [StatisticsController::class, 'show'])->name('statistics.show');

    // Уведомления
    Route::get('/notifications', [NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Профиль
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile.view');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Маршруты для донатов
    Route::get('/donations/my', [DonationController::class, 'myDonations'])->name('donations.my');
    Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
    Route::match(['put', 'patch'], '/donations/{donation}', [DonationController::class, 'update'])->name('donations.update');
    Route::delete('/donations/{donation}', [DonationController::class, 'destroy'])->name('donations.destroy');
    Route::get('/api/donations/stats', [DonationController::class, 'apiStats'])->name('donations.api.stats');
});

require __DIR__.'/auth.php';