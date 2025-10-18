<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Перенаправление с главной страницы на задачи (для авторизованных)
Route::get('/', function () {
    return redirect()->route('tasks.index');
})->middleware('auth');

// Группа маршрутов задач
Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

require __DIR__.'/auth.php';