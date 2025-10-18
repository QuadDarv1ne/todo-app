<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Access\AuthorizationException;

// use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller;

class TaskController extends Controller
{
    /**
     * Создаёт экземпляр контроллера.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Отображает список задач текущего пользователя.
     */
    public function index(Request $request)
    {
        $tasks = $request->user()
            ->tasks()
            ->latest()
            ->get(['id', 'title', 'description', 'completed', 'created_at']);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Создаёт новую задачу для текущего пользователя.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:65535',
        ]);

        $task = $request->user()->tasks()->create($data);

        return response()->json([
            'success' => true,
            'task' => $task->only(['id', 'title', 'description', 'completed', 'created_at']),
        ], 201);
    }

    /**
     * Обновляет статус выполнения задачи.
     *
     * @throws AuthorizationException
     */
    public function update(Request $request, Task $task): JsonResponse
    {
        $this->authorize('update', $task);

        $data = $request->validate([
            'completed' => 'required|boolean',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string|max:65535',
        ]);

        $task->update($data);

        return response()->json([
            'success' => true,
            'task' => $task->only(['id', 'title', 'description', 'completed', 'updated_at']),
        ]);
    }

    /**
     * Удаляет задачу.
     *
     * @throws AuthorizationException
     */
    public function destroy(Task $task): JsonResponse
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json(['success' => true]);
    }
}