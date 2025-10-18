<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Разрешить пользователю создавать задачи.
     */
    public function create(User $user): bool
    {
        return true; // Любой авторизованный пользователь может создавать задачи
    }

    /**
     * Разрешить пользователю обновлять задачу, только если она принадлежит ему.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     * Разрешить пользователю удалять задачу, только если она принадлежит ему.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     * Разрешить пользователю просматривать задачу, только если она принадлежит ему.
     */
    public function view(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     * Просмотр списка задач разрешён (но в контроллере мы и так фильтруем по пользователю).
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    // Остальные методы (restore, forceDelete) можно оставить, если не используете soft deletes
    public function restore(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    public function forceDelete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }
}