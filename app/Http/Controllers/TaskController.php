<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Helpers\TaskHelper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

/**
 * Class TaskController
 *
 * Контроллер для управления задачами пользователей.
 * Обрабатывает создание, чтение, обновление и удаление задач,
 * а также изменение их порядка через drag & drop.
 */
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
        $search = $request->query('search');
        
        $query = TaskHelper::getFilteredTasks($request->user(), $filter);
        
        // Добавляем поиск, если он есть
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $tasks = $query->paginate(10)->appends($request->except('page'));

        return view('tasks.index', compact('tasks', 'filter'));
    }

    /**
     * Возвращает данные одной задачи в формате JSON.
     */
    public function show(Task $task): JsonResponse
    {
        try {
            $this->authorize('view', $task);

            return response()->json([
                'success' => true,
                'task' => $task->toArray()
            ]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'У вас нет прав для просмотра этой задачи'
            ], 403);
        } catch (\Exception $e) {
            Log::error('Error fetching task: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при получении данных задачи'
            ], 500);
        }
    }

    /**
     * Создаёт новую задачу.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $maxOrder = $request->user()->tasks()->max('order') ?? 0;
            $task = $request->user()->tasks()->create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'due_date' => $data['due_date'] ?? null,
                'order' => $maxOrder + 1,
                'completed' => false,
            ]);

            return response()->json([
                'success' => true,
                'task' => $task->only(['id', 'title', 'description', 'completed', 'order', 'due_date', 'created_at', 'updated_at']),
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating task: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при создании задачи'
            ], 500);
        }
    }

    /**
     * Обновляет задачу (статус, заголовок, описание).
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        try {
            $this->authorize('update', $task);

            $task->update($request->validated());

            return response()->json([
                'success' => true,
                'task' => $task->only(['id', 'title', 'description', 'completed', 'order', 'due_date', 'updated_at']),
            ]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'У вас нет прав для изменения этой задачи'
            ], 403);
        } catch (\Exception $e) {
            Log::error('Error updating task: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при обновлении задачи'
            ], 500);
        }
    }

    /**
     * Удаляет задачу.
     */
    public function destroy(Task $task): JsonResponse
    {
        try {
            $this->authorize('delete', $task);
            $task->delete();

            return response()->json(['success' => true]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'У вас нет прав для удаления этой задачи'
            ], 403);
        } catch (\Exception $e) {
            Log::error('Error deleting task: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении задачи'
            ], 500);
        }
    }

    /**
     * Обновляет порядок задач (drag & drop).
     */
    public function reorder(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'tasks' => 'required|array',
                'tasks.*.id' => 'required|exists:tasks,id',
                'tasks.*.order' => 'integer|min:0',
            ]);

            $success = TaskHelper::reorderTasks($request->user(), $request->tasks);

            if (!$success) {
                throw new AuthorizationException('Вы можете изменять только свои задачи.');
            }

            return response()->json(['success' => true]);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 403);
        } catch (\Exception $e) {
            Log::error('Error reordering tasks: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при изменении порядка задач'
            ], 500);
        }
    }
}