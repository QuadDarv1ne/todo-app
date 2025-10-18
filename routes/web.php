<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;

Route::resource('tasks', TaskController::class)->except(['show', 'edit', 'create']);

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Route::get('/', function () {
    return view('welcome');
});
