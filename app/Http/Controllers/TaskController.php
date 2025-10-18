<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    /**
     * Применяет middleware 'auth' ко всем методам контроллера.
     * Это гарантирует, что только авторизованные пользователи могут управлять задачами.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Отображает список задач текущего пользователя.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Получаем задачи текущего пользователя, отсортированные по дате создания (новые — сверху)
        $tasks = auth()->user()->tasks()->latest()->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Создаёт новую задачу для текущего пользователя.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Валидация входящих данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Создаём задачу, автоматически привязывая её к текущему пользователю
        $task = auth()->user()->tasks()->create($validated);

        return response()->json([
            'success' => true,
            'task' => $task,
        ]);
    }

    /**
     * Обновляет статус выполнения задачи.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Task $task): JsonResponse
    {
        // Проверяем, что задача принадлежит текущему пользователю
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Доступ запрещён'], 403);
        }

        // Обновляем статус (ожидается boolean из запроса)
        $task->update([
            'completed' => $request->boolean('completed'),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Удаляет задачу.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task): JsonResponse
    {
        // Проверяем принадлежность задачи
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Доступ запрещён'], 403);
        }

        $task->delete();

        return response()->json(['success' => true]);
    }
}