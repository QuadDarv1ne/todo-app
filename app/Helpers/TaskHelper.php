<?php

namespace App\Helpers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class TaskHelper
{
    /**
     * Получить статистику задач пользователя.
     *
     * @param User $user
     * @return array
     */
    public static function getUserTaskStats(User $user): array
    {
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
        return $user->tasks()->orderBy('created_at', 'desc')->limit($limit)->get();
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

            return true;
        } catch (\Exception $e) {
            Log::error('Error reordering tasks: ' . $e->getMessage());
            return false;
        }
    }
}