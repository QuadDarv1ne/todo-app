<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    /**
     * Отображает список задач текущего пользователя.
     */
    public function index(Request $request)
    {
        // Получаем параметр фильтрации
        $filter = $request->query('filter', 'all');
        
        $query = $request->user()->tasks()->orderBy('order');
        
        switch ($filter) {
            case 'completed':
                $query->where('completed', true);
                break;
            case 'pending':
                $query->where('completed', false);
                break;
            // 'all' по умолчанию - все задачи
        }
        
        $tasks = $query->get(['id', 'title', 'description', 'completed', 'order', 'created_at']);

        return view('tasks.index', compact('tasks', 'filter'));
    }

    /**
     * Создаёт новую задачу.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:65535',
        ]);

        $maxOrder = $request->user()->tasks()->max('order');
        $task = $request->user()->tasks()->create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'order' => $maxOrder + 1,
            'completed' => false,
        ]);

        return response()->json([
            'success' => true,
            'task' => $task->only(['id', 'title', 'description', 'completed', 'order', 'created_at']),
        ], 201);
    }

    /**
     * Обновляет задачу (статус, заголовок, описание).
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $this->authorize('update', $task);

        $task->update($request->validated());

        return response()->json([
            'success' => true,
            'task' => $task->only(['id', 'title', 'description', 'completed', 'order', 'updated_at']),
        ]);
    }

    /**
     * Удаляет задачу.
     */
    public function destroy(Task $task): JsonResponse
    {
        $this->authorize('delete', $task);
        $task->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Обновляет порядок задач (drag & drop).
     */
    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'tasks' => 'required|array',
            'tasks.*.id' => 'required|exists:tasks,id',
            'tasks.*.order' => 'integer|min:0',
        ]);

        $taskIds = collect($request->tasks)->pluck('id')->toArray();
        $userTaskCount = $request->user()
            ->tasks()
            ->whereIn('id', $taskIds)
            ->count();

        if ($userTaskCount !== count($taskIds)) {
            throw new AuthorizationException('Вы можете изменять только свои задачи.');
        }

        foreach ($request->tasks as $item) {
            Task::where('id', $item['id'])
                ->where('user_id', $request->user()->id)
                ->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}