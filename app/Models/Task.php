<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task extends Model
{
    use HasFactory;

    /**
     * Поля, разрешённые для массового заполнения (через create() или update()).
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'description', 'completed'];

    /**
     * Определяет отношение "многие к одному": задача принадлежит одному пользователю.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}