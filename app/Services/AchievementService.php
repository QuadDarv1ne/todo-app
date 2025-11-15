<?php

namespace App\Services;

use App\Models\User;
use App\Models\Achievement;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AchievementService
{
    public function __construct(private ?ActivityLogService $activityLogService = null)
    {
    }

    /**
     * Проверить и разблокировать достижения для пользователя.
     *
     * @param User $user
     * @return array Массив разблокированных достижений
     */
    public function checkAndUnlockAchievements(User $user): array
    {
        $unlockedAchievements = [];
        
        // Получаем все достижения, которые еще не разблокированы
        $achievements = Achievement::whereDoesntHave('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        foreach ($achievements as $achievement) {
            if ($this->checkRequirements($user, $achievement)) {
                $this->unlockAchievement($user, $achievement);
                $unlockedAchievements[] = $achievement;
            }
        }

        return $unlockedAchievements;
    }

    /**
     * Проверить требования для достижения.
     *
     * @param User $user
     * @param Achievement $achievement
     * @return bool
     */
    private function checkRequirements(User $user, Achievement $achievement): bool
    {
        if (!$achievement->requirements) {
            return false;
        }

        $requirements = $achievement->requirements;

        // Проверка количества выполненных задач
        if (isset($requirements['completed_tasks'])) {
            $completedTasks = $user->tasks()->where('completed', true)->count();
            if ($completedTasks < $requirements['completed_tasks']) {
                return false;
            }
        }

        // Проверка количества всех задач
        if (isset($requirements['total_tasks'])) {
            $totalTasks = $user->tasks()->count();
            if ($totalTasks < $requirements['total_tasks']) {
                return false;
            }
        }

        // Проверка уровня пользователя
        if (isset($requirements['level'])) {
            if ($user->level < $requirements['level']) {
                return false;
            }
        }

        // Проверка серии дней
        if (isset($requirements['streak_days'])) {
            if ($user->streak_days < $requirements['streak_days']) {
                return false;
            }
        }

        // Проверка количества тегов
        if (isset($requirements['tags_count'])) {
            $tagsCount = $user->tags()->count();
            if ($tagsCount < $requirements['tags_count']) {
                return false;
            }
        }

        // Проверка процента выполнения
        if (isset($requirements['completion_rate'])) {
            $totalTasks = $user->tasks()->count();
            if ($totalTasks > 0) {
                $completedTasks = $user->tasks()->where('completed', true)->count();
                $completionRate = ($completedTasks / $totalTasks) * 100;
                if ($completionRate < $requirements['completion_rate']) {
                    return false;
                }
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Разблокировать достижение для пользователя.
     *
     * @param User $user
     * @param Achievement $achievement
     * @return void
     */
    public function unlockAchievement(User $user, Achievement $achievement): void
    {
        if (!$achievement->isUnlockedBy($user)) {
            $user->achievements()->attach($achievement->id, [
                'unlocked_at' => now(),
            ]);

            // Начисляем очки опыта
            $this->awardExperience($user, $achievement->points);

            // Логируем получение достижения
            if ($this->activityLogService) {
                $this->activityLogService->logAchievementUnlocked($user, $achievement);
            }

            // Очищаем кэш достижений пользователя
            Cache::forget("user_{$user->id}_achievements");

            Log::info("Achievement unlocked", [
                'user_id' => $user->id,
                'achievement_id' => $achievement->id,
                'achievement_name' => $achievement->name,
                'points' => $achievement->points,
            ]);
        }
    }

    /**
     * Начислить опыт пользователю.
     *
     * @param User $user
     * @param int $points
     * @return void
     */
    public function awardExperience(User $user, int $points): void
    {
        $user->experience_points += $points;
        $oldLevel = $user->level;
        
        // Проверяем повышение уровня
        $newLevel = $this->calculateLevel($user->experience_points);
        if ($newLevel > $user->level) {
            $user->level = $newLevel;
            
            // Логируем повышение уровня
            if ($this->activityLogService) {
                $this->activityLogService->logLevelUp($user, $newLevel, $points);
            }
            
            Log::info("User leveled up", [
                'user_id' => $user->id,
                'old_level' => $oldLevel,
                'new_level' => $newLevel,
            ]);
        }

        $user->save();
    }

    /**
     * Рассчитать уровень на основе опыта.
     *
     * @param int $experience
     * @return int
     */
    private function calculateLevel(int $experience): int
    {
        // Формула: уровень = floor(sqrt(опыт / 100)) + 1
        return (int) floor(sqrt($experience / 100)) + 1;
    }

    /**
     * Получить опыт, необходимый для следующего уровня.
     *
     * @param int $currentLevel
     * @return int
     */
    public function getExperienceForNextLevel(int $currentLevel): int
    {
        return (int) pow($currentLevel, 2) * 100;
    }

    /**
     * Обновить серию дней для пользователя.
     *
     * @param User $user
     * @return void
     */
    public function updateStreak(User $user): void
    {
        $today = today();
        $lastActivity = $user->last_activity_date;

        if (!$lastActivity) {
            // Первая активность
            $user->streak_days = 1;
            $user->last_activity_date = $today;
        } elseif ($lastActivity->isYesterday()) {
            // Продолжение серии
            $user->streak_days += 1;
            $user->last_activity_date = $today;
        } elseif ($lastActivity->isToday()) {
            // Уже была активность сегодня
            return;
        } else {
            // Серия прервана
            $user->streak_days = 1;
            $user->last_activity_date = $today;
        }

        $user->save();

        // Проверяем достижения, связанные с серией
        $this->checkAndUnlockAchievements($user);
    }

    /**
     * Получить все достижения пользователя.
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserAchievements(User $user)
    {
        return Cache::remember("user_{$user->id}_achievements", 3600, function () use ($user) {
            return $user->achievements()
                ->withPivot('unlocked_at')
                ->orderBy('user_achievements.unlocked_at', 'desc')
                ->get();
        });
    }

    /**
     * Получить прогресс пользователя.
     *
     * @param User $user
     * @return array
     */
    public function getUserProgress(User $user): array
    {
        $currentExp = $user->experience_points;
        $currentLevel = $user->level;
        $expForCurrentLevel = $this->getExperienceForNextLevel($currentLevel - 1);
        $expForNextLevel = $this->getExperienceForNextLevel($currentLevel);
        
        $expInCurrentLevel = $currentExp - $expForCurrentLevel;
        $expRequiredForLevel = $expForNextLevel - $expForCurrentLevel;
        
        $progressPercentage = $expRequiredForLevel > 0 
            ? round(($expInCurrentLevel / $expRequiredForLevel) * 100) 
            : 0;

        return [
            'level' => $currentLevel,
            'current_exp' => $currentExp,
            'exp_for_next_level' => $expForNextLevel,
            'exp_in_current_level' => $expInCurrentLevel,
            'exp_required_for_level' => $expRequiredForLevel,
            'progress_percentage' => $progressPercentage,
            'streak_days' => $user->streak_days,
            'achievements_count' => $user->achievements()->count(),
            'total_achievements' => Achievement::count(),
        ];
    }

    /**
     * Создать начальные достижения.
     *
     * @return void
     */
    public function seedAchievements(): void
    {
        $achievements = [
            // Задачи
            [
                'name' => 'Первые шаги',
                'slug' => 'first-task',
                'description' => 'Создайте свою первую задачу',
                'icon' => '🎯',
                'category' => Achievement::CATEGORY_TASKS,
                'points' => 10,
                'requirements' => ['total_tasks' => 1],
            ],
            [
                'name' => 'Начинающий',
                'slug' => 'completed-10-tasks',
                'description' => 'Завершите 10 задач',
                'icon' => '⭐',
                'category' => Achievement::CATEGORY_TASKS,
                'points' => 50,
                'requirements' => ['completed_tasks' => 10],
            ],
            [
                'name' => 'Профессионал',
                'slug' => 'completed-50-tasks',
                'description' => 'Завершите 50 задач',
                'icon' => '🏆',
                'category' => Achievement::CATEGORY_TASKS,
                'points' => 200,
                'requirements' => ['completed_tasks' => 50],
            ],
            [
                'name' => 'Мастер задач',
                'slug' => 'completed-100-tasks',
                'description' => 'Завершите 100 задач',
                'icon' => '👑',
                'category' => Achievement::CATEGORY_TASKS,
                'points' => 500,
                'requirements' => ['completed_tasks' => 100],
            ],

            // Продуктивность
            [
                'name' => 'Перфекционист',
                'slug' => 'perfect-completion',
                'description' => 'Завершите все задачи (100% выполнение)',
                'icon' => '💯',
                'category' => Achievement::CATEGORY_PRODUCTIVITY,
                'points' => 100,
                'requirements' => ['completion_rate' => 100],
            ],
            [
                'name' => 'Организатор',
                'slug' => 'created-5-tags',
                'description' => 'Создайте 5 тегов',
                'icon' => '🏷️',
                'category' => Achievement::CATEGORY_PRODUCTIVITY,
                'points' => 30,
                'requirements' => ['tags_count' => 5],
            ],

            // Серия
            [
                'name' => 'На старте',
                'slug' => 'streak-3-days',
                'description' => 'Поддерживайте активность 3 дня подряд',
                'icon' => '🔥',
                'category' => Achievement::CATEGORY_STREAK,
                'points' => 50,
                'requirements' => ['streak_days' => 3],
            ],
            [
                'name' => 'Стабильность',
                'slug' => 'streak-7-days',
                'description' => 'Поддерживайте активность 7 дней подряд',
                'icon' => '⚡',
                'category' => Achievement::CATEGORY_STREAK,
                'points' => 100,
                'requirements' => ['streak_days' => 7],
            ],
            [
                'name' => 'Месячный марафон',
                'slug' => 'streak-30-days',
                'description' => 'Поддерживайте активность 30 дней подряд',
                'icon' => '🌟',
                'category' => Achievement::CATEGORY_STREAK,
                'points' => 500,
                'requirements' => ['streak_days' => 30],
            ],

            // Особые
            [
                'name' => 'Уровень 10',
                'slug' => 'level-10',
                'description' => 'Достигните 10 уровня',
                'icon' => '🎖️',
                'category' => Achievement::CATEGORY_SPECIAL,
                'points' => 300,
                'requirements' => ['level' => 10],
            ],
        ];

        foreach ($achievements as $achievementData) {
            Achievement::updateOrCreate(
                ['slug' => $achievementData['slug']],
                $achievementData
            );
        }
    }
}
