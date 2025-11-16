<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ReminderController;
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
    
    // Массовые операции с задачами
    Route::post('/tasks/bulk/complete', [TaskController::class, 'bulkComplete'])->name('tasks.bulk.complete');
    Route::post('/tasks/bulk/delete', [TaskController::class, 'bulkDelete'])->name('tasks.bulk.delete');
    Route::post('/tasks/bulk/priority', [TaskController::class, 'bulkPriority'])->name('tasks.bulk.priority');
    
    // Подзадачи
    Route::get('/tasks/{task}/subtasks', [App\Http\Controllers\SubtaskController::class, 'index'])->name('subtasks.index');
    Route::post('/tasks/{task}/subtasks', [App\Http\Controllers\SubtaskController::class, 'store'])->name('subtasks.store');
    Route::patch('/tasks/{task}/subtasks/{subtask}', [App\Http\Controllers\SubtaskController::class, 'update'])->name('subtasks.update');
    Route::delete('/tasks/{task}/subtasks/{subtask}', [App\Http\Controllers\SubtaskController::class, 'destroy'])->name('subtasks.destroy');
    Route::post('/tasks/{task}/subtasks/reorder', [App\Http\Controllers\SubtaskController::class, 'reorder'])->name('subtasks.reorder');

    // Шаблоны задач
    Route::get('/templates', [App\Http\Controllers\TaskTemplateController::class, 'index'])->name('templates.index');
    Route::get('/templates/export', [App\Http\Controllers\TaskTemplateController::class, 'export'])->name('templates.export');
    Route::post('/templates/import', [App\Http\Controllers\TaskTemplateController::class, 'import'])->name('templates.import');
    Route::get('/templates/{template}', [App\Http\Controllers\TaskTemplateController::class, 'show'])->name('templates.show');
    Route::post('/templates', [App\Http\Controllers\TaskTemplateController::class, 'store'])->name('templates.store');
    Route::match(['put', 'patch'], '/templates/{template}', [App\Http\Controllers\TaskTemplateController::class, 'update'])->name('templates.update');
    Route::delete('/templates/{template}', [App\Http\Controllers\TaskTemplateController::class, 'destroy'])->name('templates.destroy');
    Route::get('/templates/apply/{template}', [App\Http\Controllers\TaskTemplateController::class, 'apply'])->name('templates.apply');
    
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

    // Достижения
    Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements.index');
    Route::post('/achievements/check', [AchievementController::class, 'check'])->name('achievements.check');

    // История активности
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-logs/{log}', [ActivityLogController::class, 'show'])->name('activity-logs.show');
    Route::post('/activity-logs/cleanup', [ActivityLogController::class, 'cleanup'])->name('activity-logs.cleanup');

    // Напоминания
    Route::get('/reminders', [ReminderController::class, 'index'])->name('reminders.index');
    Route::patch('/reminders', [ReminderController::class, 'update'])->name('reminders.update');

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

// Sitemap route (public)
Route::get('/sitemap.xml', function () {
    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
    
    // Home page
    $sitemap .= '  <url>' . PHP_EOL;
    $sitemap .= '    <loc>' . url('/') . '</loc>' . PHP_EOL;
    $sitemap .= '    <lastmod>' . now()->toAtomString() . '</lastmod>' . PHP_EOL;
    $sitemap .= '    <changefreq>daily</changefreq>' . PHP_EOL;
    $sitemap .= '    <priority>1.0</priority>' . PHP_EOL;
    $sitemap .= '  </url>' . PHP_EOL;
    
    // Login page
    $sitemap .= '  <url>' . PHP_EOL;
    $sitemap .= '    <loc>' . route('login') . '</loc>' . PHP_EOL;
    $sitemap .= '    <lastmod>' . now()->toAtomString() . '</lastmod>' . PHP_EOL;
    $sitemap .= '    <changefreq>monthly</changefreq>' . PHP_EOL;
    $sitemap .= '    <priority>0.8</priority>' . PHP_EOL;
    $sitemap .= '  </url>' . PHP_EOL;
    
    // Register page
    $sitemap .= '  <url>' . PHP_EOL;
    $sitemap .= '    <loc>' . route('register') . '</loc>' . PHP_EOL;
    $sitemap .= '    <lastmod>' . now()->toAtomString() . '</lastmod>' . PHP_EOL;
    $sitemap .= '    <changefreq>monthly</changefreq>' . PHP_EOL;
    $sitemap .= '    <priority>0.8</priority>' . PHP_EOL;
    $sitemap .= '  </url>' . PHP_EOL;
    
    $sitemap .= '</urlset>';
    
    return response($sitemap, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

// Robots.txt route (already exists as static file, but can be dynamic)
Route::get('/robots.txt', function () {
    $robots = "User-agent: *" . PHP_EOL;
    $robots .= "Allow: /" . PHP_EOL;
    $robots .= "Disallow: /dashboard" . PHP_EOL;
    $robots .= "Disallow: /profile" . PHP_EOL;
    $robots .= "Disallow: /tasks" . PHP_EOL;
    $robots .= "Disallow: /notifications" . PHP_EOL;
    $robots .= "Disallow: /activity-logs" . PHP_EOL;
    $robots .= PHP_EOL;
    $robots .= "Sitemap: " . url('/sitemap.xml') . PHP_EOL;
    
    return response($robots, 200)->header('Content-Type', 'text/plain');
});

require __DIR__.'/auth.php';