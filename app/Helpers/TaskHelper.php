<?php

namespace App\Helpers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

/**
 * Class TaskHelper
 *
 * Вспомогательный класс для работы с задачами.
 * Содержит статические методы для получения статистики,
 * фильтрации и изменения порядка задач.
 */
class TaskHelper
{
    /**
     * Получить ключ кэша для задач пользователя.
     *
     * @param User $user
     * @param string $suffix
     * @return string
     */
    private static function getCacheKey(User $user, string $suffix = ''): string
    {
        return "user_{$user->id}_tasks" . ($suffix ? "_{$suffix}" : '');
    }

    /**
     * Очистить кэш задач пользователя.
     *
     * @param User $user
     * @return void
     */
    public static function clearUserTasksCache(User $user): void
    {
        Cache::forget(self::getCacheKey($user, 'stats'));
        Cache::forget(self::getCacheKey($user, 'recent'));
        Cache::forget(self::getCacheKey($user, 'all'));
        Cache::forget(self::getCacheKey($user, 'completed'));
        Cache::forget(self::getCacheKey($user, 'pending'));
        Cache::forget(self::getCacheKey($user, 'advanced_stats'));
        Cache::forget(self::getCacheKey($user, 'tag_stats'));
        Cache::forget(self::getCacheKey($user, 'tasks_by_day'));
    }

    /**
     * Получить статистику задач пользователя.
     *
     * @param User $user
     * @return array
     */
    public static function getUserTaskStats(User $user): array
    {
        return Cache::remember(self::getCacheKey($user, 'stats'), 300, function () use ($user) {
            $totalTasks = $user->tasks()->count();
            $completedTasks = $user->tasks()->where('completed', true)->count();
            $pendingTasks = $user->tasks()->where('completed', false)->count();
            
            $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
            
            return [
                'total' => $totalTasks,
                'completed' => $completedTasks,
                'pending' => $pendingTasks,
                'completion_percentage' => $completionPercentage
            ];
        });
    }

    /**
     * Получить последние задачи пользователя.
     *
     * @param User $user
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getRecentTasks(User $user, int $limit = 5)
    {
        return Cache::remember(self::getCacheKey($user, 'recent'), 300, function () use ($user, $limit) {
            return $user->tasks()->orderBy('created_at', 'desc')->limit($limit)->get();
        });
    }

    /**
     * Получить задачи по фильтру.
     *
     * @param User $user
     * @param string $filter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getFilteredTasks(User $user, string $filter = 'all')
    {
        $query = $user->tasks()->orderBy('order');
        
        switch ($filter) {
            case 'completed':
                $query->where('completed', true);
                break;
            case 'pending':
                $query->where('completed', false);
                break;
            // 'all' по умолчанию - все задачи
        }
        
        return $query;
    }

    /**
     * Обновить порядок задач.
     *
     * @param User $user
     * @param array $tasks
     * @return bool
     */
    public static function reorderTasks(User $user, array $tasks): bool
    {
        try {
            $taskIds = collect($tasks)->pluck('id')->toArray();
            $userTaskCount = $user->tasks()
                ->whereIn('id', $taskIds)
                ->count();

            if ($userTaskCount !== count($taskIds)) {
                return false;
            }

            foreach ($tasks as $item) {
                $user->tasks()
                    ->where('id', $item['id'])
                    ->update(['order' => $item['order']]);
            }

            // Очищаем кэш после изменения порядка
            self::clearUserTasksCache($user);

            return true;
        } catch (\Exception $e) {
            Log::error('Error reordering tasks: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Получить расширенную статистику задач пользователя.
     *
     * @param User $user
     * @return array
     */
    public static function getAdvancedStats(User $user): array
    {
        return Cache::remember(self::getCacheKey($user, 'advanced_stats'), 300, function () use ($user) {
            $tasks = $user->tasks()->with('tags')->get();
            
            return [
                'total' => $tasks->count(),
                'completed' => $tasks->where('completed', true)->count(),
                'pending' => $tasks->where('completed', false)->count(),
                'overdue' => $tasks->where('completed', false)
                    ->filter(fn($task) => $task->due_date && $task->due_date->isPast())
                    ->count(),
                'high_priority' => $tasks->where('priority', 'high')->count(),
                'medium_priority' => $tasks->where('priority', 'medium')->count(),
                'low_priority' => $tasks->where('priority', 'low')->count(),
                'with_tags' => $tasks->filter(fn($task) => $task->tags->count() > 0)->count(),
                'completion_rate' => $tasks->count() > 0 
                    ? round(($tasks->where('completed', true)->count() / $tasks->count()) * 100, 1) 
                    : 0,
                'avg_completion_time' => self::getAverageCompletionTime($user),
                'tasks_by_priority' => [
                    'high' => $tasks->where('priority', 'high')->count(),
                    'medium' => $tasks->where('priority', 'medium')->count(),
                    'low' => $tasks->where('priority', 'low')->count(),
                ],
                'tasks_created_last_7_days' => $tasks->where('created_at', '>=', now()->subDays(7))->count(),
                'tasks_completed_last_7_days' => $tasks->where('completed', true)
                    ->where('updated_at', '>=', now()->subDays(7))->count(),
                // New statistics
                'completion_trend' => self::getCompletionTrend($user),
                'productivity_score' => self::calculateProductivityScore($user, $tasks),
                'tasks_by_hour' => self::getTasksByHour($user),
            ];
        });
    }

    /**
     * Получить среднее время выполнения задач (в часах).
     *
     * @param User $user
     * @return float|null
     */
    private static function getAverageCompletionTime(User $user): ?float
    {
        $completedTasks = $user->tasks()
            ->where('completed', true)
            ->whereNotNull('updated_at')
            ->get();

        if ($completedTasks->isEmpty()) {
            return null;
        }

        $totalHours = $completedTasks->sum(function ($task) {
            return $task->created_at->diffInHours($task->updated_at);
        });

        return round($totalHours / $completedTasks->count(), 1);
    }

    /**
     * Получить статистику по тегам.
     *
     * @param User $user
     * @return array
     */
    public static function getTagStats(User $user): array
    {
        return Cache::remember(self::getCacheKey($user, 'tag_stats'), 300, function () use ($user) {
            $tags = $user->tags()->withCount('tasks')->get();
            
            return $tags->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->name,
                    'color' => $tag->color,
                    'tasks_count' => $tag->tasks_count,
                ];
            })->sortByDesc('tasks_count')->values()->toArray();
        });
    }

    /**
     * Получить статистику задач по дням недели.
     *
     * @param User $user
     * @return array
     */
    public static function getTasksByDayOfWeek(User $user): array
    {
        return Cache::remember(self::getCacheKey($user, 'tasks_by_day'), 300, function () use ($user) {
            $tasks = $user->tasks;
            $days = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
            
            $byDay = collect($days)->mapWithKeys(function ($day) {
                return [$day => 0];
            });

            $tasks->each(function ($task) use (&$byDay, $days) {
                $dayOfWeek = $task->created_at->dayOfWeekIso - 1; // 0-6
                $dayName = $days[$dayOfWeek];
                $byDay[$dayName]++;
            });

            return $byDay->toArray();
        });
    }
}