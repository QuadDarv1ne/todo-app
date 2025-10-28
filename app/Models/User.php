<?php

namespace App\Models;

use App\Models\Task; // ← Обязательный импорт модели Task
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 *
 * Модель пользователя системы управления задачами.
 * 
 * @property int $id Уникальный идентификатор пользователя
 * @property string $name Имя пользователя
 * @property string $email Email пользователя
 * @property string $password Хэшированный пароль пользователя
 * @property string|null $remember_token Токен для функции "запомнить меня"
 * @property \Carbon\Carbon|null $email_verified_at Время подтверждения email
 * @property \Carbon\Carbon $created_at Время создания пользователя
 * @property \Carbon\Carbon $updated_at Время последнего обновления пользователя
 * 
 * @property-read int $task_count Общее количество задач пользователя
 * @property-read int $completed_task_count Количество завершенных задач
 * @property-read int $pending_task_count Количество активных задач
 * @property-read float $completion_percentage Процент завершения задач
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $tasks Задачи пользователя
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Поля, разрешённые для массового заполнения.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Поля, которые должны быть скрыты при сериализации (например, в JSON).
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Приведение типов для определённых атрибутов.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Автоматически хэширует пароль при сохранении
        ];
    }

    /**
     * Определяет отношение "один ко многим": один пользователь может иметь много задач.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Получить количество задач пользователя.
     *
     * @return int
     */
    public function getTaskCountAttribute(): int
    {
        return $this->tasks()->count();
    }

    /**
     * Получить количество завершенных задач пользователя.
     *
     * @return int
     */
    public function getCompletedTaskCountAttribute(): int
    {
        return $this->tasks()->where('completed', true)->count();
    }

    /**
     * Получить количество активных задач пользователя.
     *
     * @return int
     */
    public function getPendingTaskCountAttribute(): int
    {
        return $this->tasks()->where('completed', false)->count();
    }

    /**
     * Получить процент завершения задач.
     *
     * @return float
     */
    public function getCompletionPercentageAttribute(): float
    {
        $totalTasks = $this->task_count;
        if ($totalTasks === 0) {
            return 0;
        }
        return round(($this->completed_task_count / $totalTasks) * 100, 2);
    }

    /**
     * Получить последние созданные задачи.
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentTasks($limit = 5)
    {
        return $this->tasks()->orderBy('created_at', 'desc')->limit($limit)->get();
    }
}