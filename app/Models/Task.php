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
     * Отношение: задача принадлежит пользователю.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}