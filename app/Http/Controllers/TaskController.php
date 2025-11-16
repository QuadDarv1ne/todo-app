<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Helpers\TaskHelper;
use App\Events\TaskCreated;
use App\Events\TaskUpdated;
use App\Events\TaskDeleted;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function __construct(private ReportService $reportService)
    {
    }

    /**
     * Отображает список задач текущего пользователя.
     */
    public function index(Request $request)
    {
        // Получаем параметры фильтрации
        $filter = $request->query('filter', 'all');
        $search = $request->query('search');
        $priority = $request->query('priority');
        $tag = $request->query('tag');
        $dueDate = $request->query('due_date');
        
        $query = TaskHelper::getFilteredTasks($request->user(), $filter);
        
        // Поиск по названию и описанию
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Фильтр по приоритету
        if ($priority && in_array($priority, ['low', 'medium', 'high'])) {
            $query->where('priority', $priority);
        }
        
        // Фильтр по тегу
        if ($tag) {
            $query->whereHas('tags', function($q) use ($tag) {
                $q->where('tags.id', $tag);
            });
        }
        
        // Фильтр по дате выполнения
        if ($dueDate) {
            switch ($dueDate) {
                case 'today':
                    $query->whereDate('due_date', today());
                    break;
                case 'tomorrow':
                    $query->whereDate('due_date', today()->addDay());
                    break;
                case 'week':
                    $query->whereBetween('due_date', [today(), today()->addWeek()]);
                    break;
                case 'overdue':
                    $query->where('completed', false)
                          ->whereNotNull('due_date')
                          ->where('due_date', '<', now());
                    break;
            }
        }
        
        $tasks = $query->with('tags')->paginate(15)->appends($request->except('page'));
        
        // Получаем теги для фильтра
        $userTags = $request->user()->tags()->withCount('tasks')->orderBy('name')->get();

        return view('tasks.index', compact('tasks', 'filter', 'userTags'));
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
                'priority' => $data['priority'] ?? 'medium',
                'reminders_enabled' => $data['reminders_enabled'] ?? true,
                'order' => $maxOrder + 1,
                'completed' => false,
            ]);

            // Генерируем событие
            event(new TaskCreated($task));

            return response()->json([
                'success' => true,
                'task' => $task->only(['id', 'title', 'description', 'completed', 'order', 'due_date', 'priority', 'reminders_enabled', 'created_at', 'updated_at']),
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

            // Генерируем событие
            event(new TaskUpdated($task));

            return response()->json([
                'success' => true,
                'task' => $task->only(['id', 'title', 'description', 'completed', 'order', 'due_date', 'priority', 'reminders_enabled', 'updated_at']),
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
            
            // Генерируем событие до удаления (чтобы сохранить ссылку на user)
            event(new TaskDeleted($task));
            
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

    /**
     * Экспортирует задачи пользователя в JSON формате.
     */
    public function exportJson(Request $request): JsonResponse
    {
        try {
            $filter = $request->query('filter', 'all');
            $query = TaskHelper::getFilteredTasks($request->user(), $filter);
            
            $tasks = $query->get(['id', 'title', 'description', 'completed', 'due_date', 'created_at', 'updated_at']);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'user' => [
                        'id' => $request->user()->id,
                        'name' => $request->user()->name,
                        'email' => $request->user()->email,
                    ],
                    'tasks' => $tasks,
                    'exported_at' => now()->toIso8601String(),
                    'filter' => $filter,
                    'total_tasks' => $tasks->count()
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error exporting tasks to JSON: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при экспорте задач'
            ], 500);
        }
    }

    /**
     * Экспортирует задачи пользователя в CSV формате.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        try {
            $filter = $request->query('filter', 'all');
            $query = TaskHelper::getFilteredTasks($request->user(), $filter);
            
            $tasks = $query->get(['id', 'title', 'description', 'completed', 'due_date', 'created_at', 'updated_at']);
            
            $fileName = 'tasks_export_' . now()->format('Y-m-d_His') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ];
            
            return response()->stream(function () use ($tasks) {
                $handle = fopen('php://output', 'w');
                
                // Добавляем BOM для корректного отображения UTF-8 в Excel
                fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
                
                // Заголовки CSV
                fputcsv($handle, ['ID', 'Заголовок', 'Описание', 'Статус', 'Дата выполнения', 'Создана', 'Обновлена']);
                
                // Данные задач
                foreach ($tasks as $task) {
                    fputcsv($handle, [
                        $task->id,
                        $task->title,
                        $task->description ?? '',
                        $task->completed ? 'Выполнена' : 'Активна',
                        $task->due_date ? $task->due_date : '',
                        $task->created_at->format('Y-m-d H:i:s'),
                        $task->updated_at->format('Y-m-d H:i:s'),
                    ]);
                }
                
                fclose($handle);
            }, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Error exporting tasks to CSV: ' . $e->getMessage());
            abort(500, 'Ошибка при экспорте задач');
        }
    }

    /**
     * Экспортирует задачи пользователя в PDF формате.
     */
    public function exportPdf(Request $request)
    {
        try {
            $filter = $request->query('filter', 'all');
            $pdf = $this->reportService->exportTasksToPdf($request->user(), $filter);
            
            $fileName = 'tasks_export_' . now()->format('Y-m-d_His') . '.pdf';
            
            return $pdf->download($fileName);
        } catch (\Exception $e) {
            Log::error('Error exporting tasks to PDF: ' . $e->getMessage());
            abort(500, 'Ошибка при экспорте задач в PDF');
        }
    }

    /**
     * Генерирует полный отчет по задачам.
     */
    public function generateReport(Request $request)
    {
        try {
            $options = [
                'include_completed' => $request->boolean('include_completed', true),
                'include_pending' => $request->boolean('include_pending', true),
                'include_statistics' => $request->boolean('include_statistics', true),
                'include_tags' => $request->boolean('include_tags', true),
            ];

            $pdf = $this->reportService->generateTaskReport($request->user(), $options);
            
            $fileName = 'task_report_' . now()->format('Y-m-d_His') . '.pdf';
            
            return $pdf->download($fileName);
        } catch (\Exception $e) {
            Log::error('Error generating task report: ' . $e->getMessage());
            abort(500, 'Ошибка при генерации отчета');
        }
    }

    /**
     * Массовое выполнение задач.
     */
    public function bulkComplete(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'task_ids' => 'required|array',
                'task_ids.*' => 'required|exists:tasks,id',
            ]);

            $updated = 0;
            foreach ($request->task_ids as $taskId) {
                $task = Task::find($taskId);
                if ($task && $task->user_id === $request->user()->id) {
                    $task->update(['completed' => true]);
                    event(new TaskUpdated($task));
                    $updated++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Выполнено задач: {$updated}",
                'updated' => $updated
            ]);
        } catch (\Exception $e) {
            Log::error('Error bulk completing tasks: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при выполнении операции'
            ], 500);
        }
    }

    /**
     * Массовое удаление задач.
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'task_ids' => 'required|array',
                'task_ids.*' => 'required|exists:tasks,id',
            ]);

            $deleted = 0;
            foreach ($request->task_ids as $taskId) {
                $task = Task::find($taskId);
                if ($task && $task->user_id === $request->user()->id) {
                    event(new TaskDeleted($task));
                    $task->delete();
                    $deleted++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Удалено задач: {$deleted}",
                'deleted' => $deleted
            ]);
        } catch (\Exception $e) {
            Log::error('Error bulk deleting tasks: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении задач'
            ], 500);
        }
    }

    /**
     * Массовое изменение приоритета задач.
     */
    public function bulkPriority(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'task_ids' => 'required|array',
                'task_ids.*' => 'required|exists:tasks,id',
                'priority' => 'required|string|in:low,medium,high',
            ]);

            $updated = 0;
            foreach ($request->task_ids as $taskId) {
                $task = Task::find($taskId);
                if ($task && $task->user_id === $request->user()->id) {
                    $task->update(['priority' => $request->priority]);
                    event(new TaskUpdated($task));
                    $updated++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Обновлено задач: {$updated}",
                'updated' => $updated
            ]);
        } catch (\Exception $e) {
            Log::error('Error bulk updating priority: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при изменении приоритета'
            ], 500);
        }
    }
}