<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    /**
     * Логировать действие пользователя.
     */
    public function log(
        User $user,
        string $action,
        ?string $modelType = null,
        ?int $modelId = null,
        ?string $description = null,
        array $properties = []
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Логировать создание модели.
     */
    public function logCreated(User $user, $model, ?string $description = null): ActivityLog
    {
        return $this->log(
            user: $user,
            action: 'created',
            modelType: get_class($model),
            modelId: $model->id,
            description: $description ?? "Создано: {$this->getModelName($model)}",
            properties: $this->getModelProperties($model)
        );
    }

    /**
     * Логировать обновление модели.
     */
    public function logUpdated(User $user, $model, array $changes = [], ?string $description = null): ActivityLog
    {
        return $this->log(
            user: $user,
            action: 'updated',
            modelType: get_class($model),
            modelId: $model->id,
            description: $description ?? "Обновлено: {$this->getModelName($model)}",
            properties: array_merge($this->getModelProperties($model), ['changes' => $changes])
        );
    }

    /**
     * Логировать удаление модели.
     */
    public function logDeleted(User $user, $model, ?string $description = null): ActivityLog
    {
        return $this->log(
            user: $user,
            action: 'deleted',
            modelType: get_class($model),
            modelId: $model->id,
            description: $description ?? "Удалено: {$this->getModelName($model)}",
            properties: $this->getModelProperties($model)
        );
    }

    /**
     * Логировать завершение задачи.
     */
    public function logTaskCompleted(User $user, $task): ActivityLog
    {
        return $this->log(
            user: $user,
            action: 'completed',
            modelType: get_class($task),
            modelId: $task->id,
            description: "Задача завершена: {$task->title}",
            properties: [
                'task_title' => $task->title,
                'priority' => $task->priority,
                'due_date' => $task->due_date,
            ]
        );
    }

    /**
     * Логировать возобновление задачи.
     */
    public function logTaskUncompleted(User $user, $task): ActivityLog
    {
        return $this->log(
            user: $user,
            action: 'uncompleted',
            modelType: get_class($task),
            modelId: $task->id,
            description: "Задача возобновлена: {$task->title}",
            properties: [
                'task_title' => $task->title,
                'priority' => $task->priority,
            ]
        );
    }

    /**
     * Логировать получение достижения.
     */
    public function logAchievementUnlocked(User $user, $achievement): ActivityLog
    {
        return $this->log(
            user: $user,
            action: 'achievement_unlocked',
            modelType: get_class($achievement),
            modelId: $achievement->id,
            description: "Получено достижение: {$achievement->name}",
            properties: [
                'achievement_name' => $achievement->name,
                'points' => $achievement->points,
                'category' => $achievement->category,
            ]
        );
    }

    /**
     * Логировать повышение уровня.
     */
    public function logLevelUp(User $user, int $newLevel, int $experienceGained): ActivityLog
    {
        return $this->log(
            user: $user,
            action: 'level_up',
            modelType: User::class,
            modelId: $user->id,
            description: "Повышение уровня до {$newLevel}!",
            properties: [
                'new_level' => $newLevel,
                'experience_gained' => $experienceGained,
                'total_experience' => $user->experience_points,
            ]
        );
    }

    /**
     * Логировать вход в систему.
     */
    public function logLogin(User $user): ActivityLog
    {
        return $this->log(
            user: $user,
            action: 'login',
            description: 'Вход в систему'
        );
    }

    /**
     * Логировать выход из системы.
     */
    public function logLogout(User $user): ActivityLog
    {
        return $this->log(
            user: $user,
            action: 'logout',
            description: 'Выход из системы'
        );
    }

    /**
     * Получить последние логи пользователя.
     */
    public function getRecentLogs(User $user, int $limit = 20)
    {
        return ActivityLog::forUser($user)
            ->recent($limit)
            ->get();
    }

    /**
     * Получить статистику активности пользователя.
     */
    public function getUserActivityStats(User $user): array
    {
        $logs = ActivityLog::forUser($user)->get();

        return [
            'total_actions' => $logs->count(),
            'actions_by_type' => $logs->groupBy('action')->map->count(),
            'most_active_day' => $logs->groupBy(fn($log) => $log->created_at->format('Y-m-d'))
                ->map->count()
                ->sortDesc()
                ->keys()
                ->first(),
            'recent_activity' => $logs->sortByDesc('created_at')->take(10)->values(),
        ];
    }

    /**
     * Получить название модели.
     */
    private function getModelName($model): string
    {
        $className = class_basename($model);
        
        return match($className) {
            'Task' => 'Задача',
            'Achievement' => 'Достижение',
            'Tag' => 'Тег',
            'User' => 'Пользователь',
            'Donation' => 'Донат',
            default => $className,
        };
    }

    /**
     * Получить свойства модели для логирования.
     */
    private function getModelProperties($model): array
    {
        $properties = [];

        if (method_exists($model, 'toArray')) {
            $data = $model->toArray();
            
            // Исключаем чувствительные данные
            unset($data['password'], $data['remember_token']);
            
            $properties = $data;
        }

        return $properties;
    }
}
