<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
 * @property \Carbon\Carbon|null $due_date Дата выполнения задачи (необязательно)
 * @property string $priority Приоритет задачи (low, medium, high)
 * @property bool $reminders_enabled Флаг включения напоминаний для задачи
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
     * Константы приоритетов задач.
     */
    public const PRIORITY_LOW = 'low';
    public const PRIORITY_MEDIUM = 'medium';
    public const PRIORITY_HIGH = 'high';

    /**
     * Получить все доступные приоритеты.
     *
     * @return array
     */
    public static function getPriorities(): array
    {
        return [
            self::PRIORITY_LOW => 'Низкий',
            self::PRIORITY_MEDIUM => 'Средний',
            self::PRIORITY_HIGH => 'Высокий',
        ];
    }

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
        'due_date',
        'priority',
        'reminders_enabled',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в определённые типы.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'completed' => 'boolean',
        'order'     => 'integer',
        'due_date'  => 'date',
        'reminders_enabled' => 'boolean',
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
     * Значения по умолчанию для атрибутов модели.
     *
     * @var array
     */
    protected $attributes = [
        'reminders_enabled' => true,
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
     * Отношение: задача может иметь много тегов.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'task_tag')->withTimestamps();
    }

    /**
     * Отношение: задача может иметь много подзадач.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subtasks()
    {
        return $this->hasMany(Subtask::class)->orderBy('order');
    }

    /**
     * Получить процент выполнения подзадач.
     *
     * @return float
     */
    public function getSubtasksProgressAttribute(): float
    {
        $total = $this->subtasks()->count();
        if ($total === 0) return 0;
        
        $completed = $this->subtasks()->where('completed', true)->count();
        return round(($completed / $total) * 100, 1);
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
     * Проверить, просрочена ли задача.
     *
     * @return bool
     */
    public function getIsOverdueAttribute(): bool
    {
        return !$this->completed && $this->due_date && $this->due_date->isPast();
    }

    /**
     * Получить цвет приоритета задачи.
     *
     * @return string
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            self::PRIORITY_HIGH => 'red',
            self::PRIORITY_MEDIUM => 'yellow',
            self::PRIORITY_LOW => 'gray',
            default => 'gray',
        };
    }

    /**
     * Получить название приоритета задачи.
     *
     * @return string
     */
    public function getPriorityNameAttribute(): string
    {
        return self::getPriorities()[$this->priority] ?? 'Средний';
    }

    /**
     * Получить значение приоритета для сортировки (чем выше, тем важнее).
     *
     * @return int
     */
    public function getPriorityValueAttribute(): int
    {
        return match($this->priority) {
            self::PRIORITY_HIGH => 3,
            self::PRIORITY_MEDIUM => 2,
            self::PRIORITY_LOW => 1,
            default => 2,
        };
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

    /**
     * Область запроса для просроченных задач.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query)
    {
        return $query->where('completed', false)
                     ->whereNotNull('due_date')
                     ->where('due_date', '<', now());
    }

    /**
     * Область запроса для задач с датой выполнения.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithDueDate($query)
    {
        return $query->whereNotNull('due_date');
    }

    /**
     * Область запроса для задач с определенным приоритетом.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $priority
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Область запроса для задач с высоким приоритетом.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHighPriority($query)
    {
        return $query->where('priority', self::PRIORITY_HIGH);
    }
}