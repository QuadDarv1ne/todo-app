<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Subtask;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * Class SubtaskController
 *
 * Контроллер для управления подзадачами (чек-листами).
 */
class SubtaskController extends Controller
{
    /**
     * Получить все подзадачи для задачи.
     */
    public function index(Task $task): JsonResponse
    {
        try {
            // Проверяем права доступа
            if ($task->user_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'У вас нет прав для просмотра этих подзадач'
                ], 403);
            }

            $subtasks = $task->subtasks()->get();

            return response()->json([
                'success' => true,
                'subtasks' => $subtasks,
                'progress' => $task->subtasksProgress
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching subtasks: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при получении подзадач'
            ], 500);
        }
    }

    /**
     * Создать новую подзадачу.
     */
    public function store(Request $request, Task $task): JsonResponse
    {
        try {
            // Проверяем права доступа
            if ($task->user_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'У вас нет прав для создания подзадач'
                ], 403);
            }

            $validated = $request->validate([
                'title' => 'required|string|max:255',
            ]);

            // Получаем максимальный order
            $maxOrder = $task->subtasks()->max('order') ?? 0;

            $subtask = $task->subtasks()->create([
                'title' => $validated['title'],
                'order' => $maxOrder + 1,
                'completed' => false,
            ]);

            return response()->json([
                'success' => true,
                'subtask' => $subtask,
                'progress' => $task->fresh()->subtasksProgress
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating subtask: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при создании подзадачи'
            ], 500);
        }
    }

    /**
     * Обновить подзадачу.
     */
    public function update(Request $request, Task $task, Subtask $subtask): JsonResponse
    {
        try {
            // Проверяем права доступа
            if ($task->user_id !== auth()->id() || $subtask->task_id !== $task->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'У вас нет прав для изменения этой подзадачи'
                ], 403);
            }

            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'completed' => 'sometimes|boolean',
            ]);

            $subtask->update($validated);

            return response()->json([
                'success' => true,
                'subtask' => $subtask->fresh(),
                'progress' => $task->fresh()->subtasksProgress
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating subtask: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при обновлении подзадачи'
            ], 500);
        }
    }

    /**
     * Удалить подзадачу.
     */
    public function destroy(Task $task, Subtask $subtask): JsonResponse
    {
        try {
            // Проверяем права доступа
            if ($task->user_id !== auth()->id() || $subtask->task_id !== $task->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'У вас нет прав для удаления этой подзадачи'
                ], 403);
            }

            $subtask->delete();

            return response()->json([
                'success' => true,
                'progress' => $task->fresh()->subtasksProgress
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting subtask: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении подзадачи'
            ], 500);
        }
    }

    /**
     * Изменить порядок подзадач.
     */
    public function reorder(Request $request, Task $task): JsonResponse
    {
        try {
            // Проверяем права доступа
            if ($task->user_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'У вас нет прав для изменения порядка подзадач'
                ], 403);
            }

            $validated = $request->validate([
                'subtasks' => 'required|array',
                'subtasks.*.id' => 'required|exists:subtasks,id',
                'subtasks.*.order' => 'integer|min:0',
            ]);

            foreach ($validated['subtasks'] as $item) {
                $subtask = Subtask::find($item['id']);
                if ($subtask && $subtask->task_id === $task->id) {
                    $subtask->update(['order' => $item['order']]);
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error reordering subtasks: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при изменении порядка подзадач'
            ], 500);
        }
    }
}
