<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'category',
        'points',
        'requirements',
        'is_secret',
    ];

    protected $casts = [
        'requirements' => 'array',
        'is_secret' => 'boolean',
    ];

    /**
     * Категории достижений
     */
    const CATEGORY_TASKS = 'tasks';
    const CATEGORY_PRODUCTIVITY = 'productivity';
    const CATEGORY_SOCIAL = 'social';
    const CATEGORY_STREAK = 'streak';
    const CATEGORY_SPECIAL = 'special';

    /**
     * Пользователи, которые разблокировали это достижение.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_achievements')
            ->withTimestamp()
            ->withPivot('unlocked_at');
    }

    /**
     * Проверить, разблокировано ли достижение для пользователя.
     */
    public function isUnlockedBy(User $user): bool
    {
        return $this->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Получить процент пользователей, которые разблокировали это достижение.
     */
    public function getUnlockRateAttribute(): float
    {
        $totalUsers = User::count();
        if ($totalUsers === 0) return 0;

        $unlockedCount = $this->users()->count();
        return round(($unlockedCount / $totalUsers) * 100, 1);
    }

    /**
     * Получить название категории.
     */
    public function getCategoryNameAttribute(): string
    {
        return match ($this->category) {
            self::CATEGORY_TASKS => 'Задачи',
            self::CATEGORY_PRODUCTIVITY => 'Продуктивность',
            self::CATEGORY_SOCIAL => 'Социальные',
            self::CATEGORY_STREAK => 'Серия',
            self::CATEGORY_SPECIAL => 'Особые',
            default => 'Общие',
        };
    }

    /**
     * Scope для фильтрации по категории.
     */
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope для публичных достижений.
     */
    public function scopePublic($query)
    {
        return $query->where('is_secret', false);
    }

    /**
     * Scope для секретных достижений.
     */
    public function scopeSecret($query)
    {
        return $query->where('is_secret', true);
    }
}
