<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function __construct(private ActivityLogService $activityLogService)
    {
    }

    /**
     * Отобразить список логов активности пользователя.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Получаем параметры фильтрации
        $action = $request->query('action');
        $modelType = $request->query('model_type');
        $perPage = $request->query('per_page', 20);

        // Базовый запрос
        $query = ActivityLog::forUser($user)->with('user');

        // Применяем фильтры
        if ($action) {
            $query->action($action);
        }

        if ($modelType) {
            $query->modelType($modelType);
        }

        // Получаем логи с пагинацией
        $logs = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Статистика активности
        $stats = $this->activityLogService->getUserActivityStats($user);

        return view('activity-logs.index', compact('logs', 'stats'));
    }

    /**
     * Показать конкретный лог.
     */
    public function show(Request $request, ActivityLog $log)
    {
        // Проверяем, что лог принадлежит текущему пользователю
        if ($log->user_id !== $request->user()->id) {
            abort(403, 'Доступ запрещен');
        }

        return view('activity-logs.show', compact('log'));
    }

    /**
     * API: получить последние логи.
     */
    public function recent(Request $request)
    {
        $user = $request->user();
        $limit = $request->query('limit', 10);

        $logs = $this->activityLogService->getRecentLogs($user, $limit);

        return response()->json([
            'success' => true,
            'logs' => $logs,
        ]);
    }

    /**
     * API: получить статистику активности.
     */
    public function stats(Request $request)
    {
        $user = $request->user();
        $stats = $this->activityLogService->getUserActivityStats($user);

        return response()->json([
            'success' => true,
            'stats' => $stats,
        ]);
    }

    /**
     * Очистить старые логи (старше 90 дней).
     */
    public function cleanup(Request $request)
    {
        $user = $request->user();
        $daysToKeep = 90;

        $deleted = ActivityLog::forUser($user)
            ->where('created_at', '<', now()->subDays($daysToKeep))
            ->delete();

        return response()->json([
            'success' => true,
            'message' => "Удалено {$deleted} записей старше {$daysToKeep} дней",
            'deleted_count' => $deleted,
        ]);
    }
}
