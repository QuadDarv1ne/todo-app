<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskDueReminder;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Отправить уведомления о приближающихся сроках задач.
     *
     * @param int $daysBeforeDue Количество дней до срока выполнения
     * @return int Количество отправленных уведомлений
     */
    public function sendTaskDueReminders(int $daysBeforeDue = 1): int
    {
        $targetDate = now()->addDays($daysBeforeDue)->startOfDay();
        $endDate = $targetDate->copy()->endOfDay();
        
        $tasks = Task::where('completed', false)
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [$targetDate, $endDate])
            ->with('user')
            ->get();

        $count = 0;
        
        foreach ($tasks as $task) {
            try {
                $task->user->notify(new TaskDueReminder($task));
                $count++;
                
                Log::info('Task due reminder sent', [
                    'task_id' => $task->id,
                    'user_id' => $task->user_id,
                    'due_date' => $task->due_date,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send task due reminder', [
                    'task_id' => $task->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $count;
    }

    /**
     * Отправить уведомления о просроченных задачах.
     *
     * @return int Количество отправленных уведомлений
     */
    public function sendOverdueTaskReminders(): int
    {
        $tasks = Task::where('completed', false)
            ->whereNotNull('due_date')
            ->where('due_date', '<', now())
            ->with('user')
            ->get();

        $count = 0;
        
        foreach ($tasks as $task) {
            try {
                $task->user->notify(new TaskDueReminder($task));
                $count++;
                
                Log::info('Overdue task reminder sent', [
                    'task_id' => $task->id,
                    'user_id' => $task->user_id,
                    'due_date' => $task->due_date,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send overdue task reminder', [
                    'task_id' => $task->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $count;
    }

    /**
     * Пометить уведомление как прочитанное.
     *
     * @param string $notificationId
     * @param User $user
     * @return bool
     */
    public function markAsRead(string $notificationId, User $user): bool
    {
        $notification = $user->notifications()->find($notificationId);
        
        if ($notification) {
            $notification->markAsRead();
            return true;
        }
        
        return false;
    }

    /**
     * Пометить все уведомления пользователя как прочитанные.
     *
     * @param User $user
     * @return int Количество помеченных уведомлений
     */
    public function markAllAsRead(User $user): int
    {
        return $user->unreadNotifications->markAsRead();
    }

    /**
     * Получить непрочитанные уведомления пользователя.
     *
     * @param User $user
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUnreadNotifications(User $user, int $limit = 10)
    {
        return $user->unreadNotifications()->limit($limit)->get();
    }

    /**
     * Удалить уведомление.
     *
     * @param string $notificationId
     * @param User $user
     * @return bool
     */
    public function deleteNotification(string $notificationId, User $user): bool
    {
        $notification = $user->notifications()->find($notificationId);
        
        if ($notification) {
            $notification->delete();
            return true;
        }
        
        return false;
    }
}
