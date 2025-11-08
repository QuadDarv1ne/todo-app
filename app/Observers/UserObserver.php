<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskLimitApproaching;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }



    public function saving(User $user)
    {
        // Автоматическая нормализация email
        if ($user->isDirty('email')) {
            $user->email = strtolower(trim($user->email));
        }
        
        // Очистка HTML-тегов из биографии для безопасности
        if ($user->isDirty('bio')) {
            $user->bio = $user->bio ? strip_tags($user->bio) : null;
        }
    }

    public function saved(User $user)
    {
        // Проверка приближения к лимиту задач
        $limit = $user->task_limit ?? config('app.default_task_limit', 100);
        $threshold = 0.9 * $limit; // 90% от лимита
        
        if ($user->task_count >= $threshold && ($user->wasRecentlyCreated || $user->isDirty('task_count'))) {
            $remaining = $limit - $user->task_count;
            
            Log::info("User {$user->id} approaching task limit: {$user->task_count}/{$limit}");
            
            if ($remaining <= 10) {
                Notification::send($user, new TaskLimitApproaching($remaining));
            }
        }
        
        // Логирование обновления биографии
        if ($user->isDirty('bio')) {
            Log::info("User {$user->id} updated bio: " . ($user->bio ? 'added/updated' : 'removed'));
        }
    }

    public function deleting(User $user)
    {
        // Логика перед удалением
        Log::warning("Deleting user {$user->id} with {$user->task_count} tasks");
        
        // Можно переместить задачи другому пользователю или архивировать
        if ($user->task_count > 0) {
            $admin = User::role('admin')->first();
            if ($admin) {
                $user->tasks()->update(['user_id' => $admin->id]);
            }
        }
        
        // Удаление файла аватара
        if ($user->avatar_path) {
            try {
                Storage::disk('public')->delete('avatars/' . $user->avatar_path);
                Log::info("Deleted avatar file for user {$user->id}: {$user->avatar_path}");
            } catch (\Exception $e) {
                Log::error("Failed to delete avatar file for user {$user->id}: " . $e->getMessage());
            }
        }
    }
}
