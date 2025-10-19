<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    /**
     * Поля, разрешённые для массового заполнения.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'completed',
        'order', // ← обязательно для сортировки!
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в определённые типы.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'completed' => 'boolean',
        'order'     => 'integer',
    ];

    /**
     * Атрибуты, которые должны быть скрыты при сериализации.
     *
     * @var array<string>
     */
    protected $hidden = [
        'user_id',
    ];

    /**
     * Отношение: задача принадлежит пользователю.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить статус задачи в виде строки.
     *
     * @return string
     */
    public function getStatusAttribute(): string
    {
        return $this->completed ? 'completed' : 'pending';
    }

    /**
     * Получить цвет статуса задачи.
     *
     * @return string
     */
    public function getStatusColorAttribute(): string
    {
        return $this->completed ? 'green' : 'yellow';
    }

    /**
     * Получить название статуса задачи.
     *
     * @return string
     */
    public function getStatusNameAttribute(): string
    {
        return $this->completed ? 'Завершено' : 'Активно';
    }

    /**
     * Область запроса для активных задач.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('completed', false);
    }

    /**
     * Область запроса для завершенных задач.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    /**
     * Область запроса для задач пользователя.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}