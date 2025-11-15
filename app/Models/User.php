<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Поля, разрешённые для массового заполнения.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'bio',          // ← Биография пользователя
        'password',
        'role',         // Роли пользователя
        'task_limit',   // Лимит задач для пользователя
        'avatar_path',  // Путь к аватару
    ];

    /**
     * Поля, которые должны быть скрыты при сериализации.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * Атрибуты, которые должны быть добавлены к массиву.
     *
     * @var list<string>
     */
    protected $appends = [
        'task_count',
        'completed_task_count',
        'pending_task_count',
        'completion_percentage',
        'can_create_more_tasks',
        'avatar_url',
        'bio_excerpt',
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
            'password' => 'hashed',
            'task_limit' => 'integer',
            'role' => 'string',
            'bio' => 'string',
            'avatar_path' => 'string',
            'level' => 'integer',
            'experience_points' => 'integer',
            'streak_days' => 'integer',
            'last_activity_date' => 'date',
        ];
    }

    // === ОПТИМИЗИРОВАННЫЕ ОТНОШЕНИЯ ===
    
    /**
     * Все задачи пользователя с возможностью eager loading
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->orderBy('created_at', 'desc');
    }

    /**
     * Завершенные задачи
     */
    public function completedTasks(): HasMany
    {
        return $this->tasks()->where('completed', true);
    }

    /**
     * Активные задачи
     */
    public function pendingTasks(): HasMany
    {
        return $this->tasks()->where('completed', false);
    }

    /**
     * Теги пользователя
     */
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class)->orderBy('name');
    }

    /**
     * Все донаты пользователя
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class)->orderBy('created_at', 'desc');
    }

    /**
     * Достижения пользователя
     */
    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
            ->withTimestamps()
            ->withPivot('unlocked_at');
    }

    // === АКСЕССОРЫ ДЛЯ ПОЛЯ BIO ===
    
    /**
     * Получить краткую версию биографии (100 символов)
     */
    public function bioExcerpt(): Attribute
    {
        return Attribute::get(function () {
            return $this->bio 
                ? Str::limit(strip_tags($this->bio), 100, '...')
                : null;
        });
    }

    /**
     * Обработать биографию перед сохранением
     */
    public function bio(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => $value ? trim($value) : null
        );
    }

    /**
     * Проверить, имеет ли пользователь биографию
     */
    public function hasBio(): bool
    {
        return !empty(trim($this->bio ?? ''));
    }

    // === РАБОТА С АВАТАРОМ ===
    
    /**
     * Получить URL аватара
     */
    public function avatarUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->avatar_path) {
                return asset('storage/avatars/' . $this->avatar_path);
            }
            
            // Генерация аватара по умолчанию на основе имени/email
            $hash = md5(strtolower(trim($this->email)));
            return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=150";
        });
    }

    // === КЭШИРУЕМЫЕ АКСЕССОРЫ ДЛЯ ЗАДАЧ ===
    
    /**
     * Кэшированное общее количество задач
     */
    public function taskCount(): Attribute
    {
        return Attribute::get(function () {
            return Cache::remember("user:{$this->id}:task_count", 3600, function () {
                return $this->tasks()->count();
            });
        });
    }

    /**
     * Кэшированное количество завершенных задач
     */
    public function completedTaskCount(): Attribute
    {
        return Attribute::get(function () {
            return Cache::remember("user:{$this->id}:completed_task_count", 3600, function () {
                return $this->completedTasks()->count();
            });
        });
    }

    /**
     * Кэшированное количество активных задач
     */
    public function pendingTaskCount(): Attribute
    {
        return Attribute::get(function () {
            return Cache::remember("user:{$this->id}:pending_task_count", 3600, function () {
                return $this->pendingTasks()->count();
            });
        });
    }

    /**
     * Процент завершения с кэшированием
     */
    public function completionPercentage(): Attribute
    {
        return Attribute::get(function () {
            $total = $this->task_count;
            if ($total === 0) return 0.0;
            
            $completed = $this->completed_task_count;
            return round(($completed / $total) * 100, 2);
        });
    }

    /**
     * Проверка возможности создания новых задач
     */
    public function canCreateMoreTasks(): Attribute
    {
        return Attribute::get(function () {
            $limit = $this->task_limit ?? config('app.default_task_limit', 100);
            return $this->task_count < $limit;
        });
    }

    // === БИЗНЕС-ЛОГИКА ===
    
    /**
     * Создать новую задачу с валидацией лимита
     */
    public function createTask(array $data): Task
    {
        if (!$this->can_create_more_tasks) {
            throw new \RuntimeException("Превышен лимит задач для пользователя");
        }

        $task = $this->tasks()->create($data);
        
        // Очищаем кэш после создания задачи
        $this->clearTaskCache();
        
        return $task;
    }

    /**
     * Обновить биографию пользователя
     */
    public function updateBio(string $bio): bool
    {
        $bio = trim($bio);
        
        if (strlen($bio) > 1000) {
            throw new \InvalidArgumentException("Биография не должна превышать 1000 символов");
        }
        
        if ($bio === '') {
            $bio = null;
        }
        
        return $this->update(['bio' => $bio]);
    }

    /**
     * Очистить кэш статистики задач
     */
    public function clearTaskCache(): void
    {
        Cache::forget("user:{$this->id}:task_count");
        Cache::forget("user:{$this->id}:completed_task_count");
        Cache::forget("user:{$this->id}:pending_task_count");
    }

    // === SCOPE МЕТОДЫ ДЛЯ ФИЛЬТРАЦИИ ===
    
    /**
     * Scope для пользователей с завершенными задачами
     */
    public function scopeHasCompletedTasks($query)
    {
        return $query->whereHas('tasks', function ($q) {
            $q->where('completed', true);
        });
    }

    /**
     * Scope для пользователей по роли
     */
    public function scopeRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope для активных пользователей (с задачами)
     */
    public function scopeActive($query)
    {
        return $query->whereHas('tasks');
    }

    /**
     * Scope для поиска по имени, email или биографии
     */
    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%")
              ->orWhere('bio', 'like', "%{$term}%");
        });
    }

    /**
     * Scope для пользователей с заполненной биографией
     */
    public function scopeWithBio($query)
    {
        return $query->whereNotNull('bio')->where('bio', '!=', '');
    }

    /**
     * Scope для пользователей без биографии
     */
    public function scopeWithoutBio($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('bio')->orWhere('bio', '');
        });
    }

    // === РОЛИ И РАЗРЕШЕНИЯ ===
    
    /**
     * Проверить, является ли пользователь администратором
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Проверить, может ли пользователь управлять другим пользователем
     */
    public function canManage(User $otherUser): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        
        return $this->id === $otherUser->id;
    }

    /**
     * Получить роль с локализацией
     */
    public function getRoleDisplayName(): string
    {
        return match ($this->role) {
            'admin' => 'Администратор',
            'manager' => 'Менеджер',
            'user' => 'Пользователь',
            default => ucfirst($this->role),
        };
    }

    // === API И СЕРИАЛИЗАЦИЯ ===
    
    /**
     * Атрибуты для API
     */
    public function toApiArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'bio' => $this->bio,
            'bio_excerpt' => $this->bio_excerpt,
            'avatar_url' => $this->avatar_url,
            'role' => $this->role,
            'role_display' => $this->getRoleDisplayName(),
            'stats' => [
                'total_tasks' => $this->task_count,
                'completed_tasks' => $this->completed_task_count,
                'pending_tasks' => $this->pending_task_count,
                'completion_percentage' => $this->completion_percentage,
            ],
            'limits' => [
                'task_limit' => $this->task_limit ?? config('app.default_task_limit', 100),
                'can_create_more_tasks' => $this->can_create_more_tasks,
            ],
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }

    /**
     * Форматировать пользователя для профиля
     */
    public function toProfileArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'bio' => $this->bio ?? 'Пользователь пока не заполнил биографию',
            'bio_html' => $this->bio ? nl2br(e($this->bio)) : null,
            'avatar' => $this->avatar_url,
            'stats' => [
                'tasks' => $this->task_count,
                'completed' => $this->completed_task_count,
                'completion_rate' => $this->completion_percentage . '%',
            ],
            'member_since' => $this->created_at->format('F Y'),
            'role' => $this->getRoleDisplayName(),
        ];
    }

    // === СОБЫТИЯ ===
    
    protected static function booted()
    {
        static::saved(function ($user) {
            $user->clearTaskCache();
        });

        static::deleted(function ($user) {
            Cache::forget("user:{$user->id}:task_count");
            Cache::forget("user:{$user->id}:completed_task_count");
            Cache::forget("user:{$user->id}:pending_task_count");
        });

        static::deleting(function ($user) {
            // Удаление файла аватара при удалении пользователя
            if ($user->avatar_path && file_exists(storage_path('app/public/avatars/' . $user->avatar_path))) {
                unlink(storage_path('app/public/avatars/' . $user->avatar_path));
            }
        });
    }
}