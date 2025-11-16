<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Subtask
 *
 * Модель подзадачи (чек-листа) для основной задачи.
 * 
 * @property int $id
 * @property int $task_id
 * @property string $title
 * @property bool $completed
 * @property int $order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property-read \App\Models\Task $task
 */
class Subtask extends Model
{
    use HasFactory;

    /**
     * Поля, разрешённые для массового заполнения.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'title',
        'completed',
        'order',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в определённые типы.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'completed' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Отношение: подзадача принадлежит задаче.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
