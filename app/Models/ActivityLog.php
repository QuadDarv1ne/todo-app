<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'properties',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Связь с пользователем.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Полиморфная связь с моделью.
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope для фильтрации по пользователю.
     */
    public function scopeForUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    /**
     * Scope для фильтрации по действию.
     */
    public function scopeAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope для фильтрации по типу модели.
     */
    public function scopeModelType($query, string $modelType)
    {
        return $query->where('model_type', $modelType);
    }

    /**
     * Scope для последних записей.
     */
    public function scopeRecent($query, int $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Получить иконку для действия.
     */
    public function getActionIconAttribute(): string
    {
        return match($this->action) {
            'created' => '➕',
            'updated' => '✏️',
            'deleted' => '🗑️',
            'completed' => '✅',
            'uncompleted' => '⏳',
            'achievement_unlocked' => '🏆',
            'level_up' => '⬆️',
            'login' => '🔑',
            'logout' => '🚪',
            default => '📝',
        };
    }

    /**
     * Получить цвет для действия.
     */
    public function getActionColorAttribute(): string
    {
        return match($this->action) {
            'created' => 'green',
            'updated' => 'blue',
            'deleted' => 'red',
            'completed' => 'green',
            'uncompleted' => 'yellow',
            'achievement_unlocked' => 'purple',
            'level_up' => 'indigo',
            'login' => 'gray',
            'logout' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Получить читаемое название действия.
     */
    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'created' => 'Создано',
            'updated' => 'Обновлено',
            'deleted' => 'Удалено',
            'completed' => 'Завершено',
            'uncompleted' => 'Возобновлено',
            'achievement_unlocked' => 'Достижение получено',
            'level_up' => 'Повышение уровня',
            'login' => 'Вход в систему',
            'logout' => 'Выход из системы',
            default => ucfirst($this->action),
        };
    }
}
