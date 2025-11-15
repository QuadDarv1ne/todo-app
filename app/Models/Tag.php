<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Tag
 *
 * Модель тега для категоризации задач.
 * 
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $color
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\Task> $tasks
 */
class Tag extends Model
{
    use HasFactory;

    /**
     * Предустановленные цвета для тегов.
     */
    public const COLORS = [
        '#ef4444', // red
        '#f59e0b', // amber
        '#10b981', // emerald
        '#3b82f6', // blue
        '#6366f1', // indigo
        '#8b5cf6', // violet
        '#ec4899', // pink
        '#6b7280', // gray
    ];

    /**
     * Поля, разрешённые для массового заполнения.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'color',
        'user_id',
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
     * Отношение: тег принадлежит пользователю.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Отношение: тег может принадлежать многим задачам.
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class)->withTimestamps();
    }

    /**
     * Получить количество задач с этим тегом.
     */
    public function getTasksCountAttribute(): int
    {
        return $this->tasks()->count();
    }
}
