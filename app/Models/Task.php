<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Task
 *
 * Модель задачи для управления списком дел пользователя.
 * 
 * @property int $id Уникальный идентификатор задачи
 * @property string $title Заголовок задачи
 * @property string|null $description Описание задачи (необязательно)
 * @property bool $completed Статус выполнения задачи
 * @property int $order Порядковый номер задачи для сортировки
 * @property int $user_id Идентификатор пользователя, которому принадлежит задача
 * @property \Carbon\Carbon $created_at Время создания задачи
 * @property \Carbon\Carbon $updated_at Время последнего обновления задачи
 * 
 * @property-read string $status Статус задачи (completed/pending)
 * @property-read string $statusColor Цвет статуса задачи (green/yellow)
 * @property-read string $statusName Название статуса задачи (Завершено/Активно)
 * 
 * @property-read \App\Models\User $user Пользователь, которому принадлежит задача
 */
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
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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