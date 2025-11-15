<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class TaskRecommendationService
{
    /**
     * Получить рекомендации для пользователя.
     *
     * @param User $user
     * @return array
     */
    public function getRecommendations(User $user): array
    {
        return Cache::remember("user_{$user->id}_recommendations", 300, function () use ($user) {
            $recommendations = [];

            // Анализ просроченных задач
            $overdueRecommendations = $this->analyzeOverdueTasks($user);
            if (!empty($overdueRecommendations)) {
                $recommendations[] = $overdueRecommendations;
            }

            // Анализ приоритетов
            $priorityRecommendations = $this->analyzePriorities($user);
            if (!empty($priorityRecommendations)) {
                $recommendations[] = $priorityRecommendations;
            }

            // Анализ загруженности
            $workloadRecommendations = $this->analyzeWorkload($user);
            if (!empty($workloadRecommendations)) {
                $recommendations[] = $workloadRecommendations;
            }

            // Анализ продуктивности
            $productivityRecommendations = $this->analyzeProductivity($user);
            if (!empty($productivityRecommendations)) {
                $recommendations[] = $productivityRecommendations;
            }

            // Рекомендации по тегам
            $tagRecommendations = $this->analyzeTags($user);
            if (!empty($tagRecommendations)) {
                $recommendations[] = $tagRecommendations;
            }

            return $recommendations;
        });
    }

    /**
     * Анализ просроченных задач.
     *
     * @param User $user
     * @return array|null
     */
    private function analyzeOverdueTasks(User $user): ?array
    {
        $overdueTasks = $user->tasks()
            ->where('completed', false)
            ->whereNotNull('due_date')
            ->where('due_date', '<', now())
            ->count();

        if ($overdueTasks > 0) {
            $urgency = $overdueTasks > 5 ? 'high' : ($overdueTasks > 2 ? 'medium' : 'low');
            
            return [
                'type' => 'overdue',
                'urgency' => $urgency,
                'title' => "У вас {$overdueTasks} просроченных задач",
                'description' => 'Рекомендуем пересмотреть сроки или завершить их в приоритетном порядке.',
                'action' => 'Просмотреть просроченные задачи',
                'action_url' => route('tasks.index', ['due_date' => 'overdue']),
                'icon' => 'alert',
            ];
        }

        return null;
    }

    /**
     * Анализ распределения приоритетов.
     *
     * @param User $user
     * @return array|null
     */
    private function analyzePriorities(User $user): ?array
    {
        $highPriorityTasks = $user->tasks()
            ->where('completed', false)
            ->where('priority', 'high')
            ->count();

        if ($highPriorityTasks > 10) {
            return [
                'type' => 'priority',
                'urgency' => 'medium',
                'title' => 'Слишком много высокоприоритетных задач',
                'description' => "У вас {$highPriorityTasks} задач с высоким приоритетом. Рассмотрите возможность перераспределения приоритетов.",
                'action' => 'Просмотреть задачи',
                'action_url' => route('tasks.index', ['priority' => 'high', 'filter' => 'pending']),
                'icon' => 'priority',
            ];
        }

        return null;
    }

    /**
     * Анализ загруженности.
     *
     * @param User $user
     * @return array|null
     */
    private function analyzeWorkload(User $user): ?array
    {
        $pendingTasks = $user->tasks()->where('completed', false)->count();
        $tasksThisWeek = $user->tasks()
            ->where('completed', false)
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        if ($tasksThisWeek > 20) {
            return [
                'type' => 'workload',
                'urgency' => 'high',
                'title' => 'Высокая загруженность на этой неделе',
                'description' => "У вас {$tasksThisWeek} задач на эту неделю. Возможно, стоит перенести часть задач.",
                'action' => 'Планировать неделю',
                'action_url' => route('tasks.index', ['due_date' => 'week']),
                'icon' => 'calendar',
            ];
        }

        if ($pendingTasks < 3) {
            return [
                'type' => 'workload',
                'urgency' => 'low',
                'title' => 'У вас мало активных задач',
                'description' => 'Отличная возможность добавить новые задачи или заняться долгосрочным планированием.',
                'action' => 'Добавить задачи',
                'action_url' => route('tasks.index'),
                'icon' => 'plus',
            ];
        }

        return null;
    }

    /**
     * Анализ продуктивности.
     *
     * @param User $user
     * @return array|null
     */
    private function analyzeProductivity(User $user): ?array
    {
        $completedLastWeek = $user->tasks()
            ->where('completed', true)
            ->whereBetween('updated_at', [now()->subWeek(), now()])
            ->count();

        $completedLastMonth = $user->tasks()
            ->where('completed', true)
            ->whereBetween('updated_at', [now()->subMonth(), now()])
            ->count();

        if ($completedLastWeek >= 10) {
            return [
                'type' => 'productivity',
                'urgency' => 'low',
                'title' => 'Отличная продуктивность!',
                'description' => "Вы завершили {$completedLastWeek} задач за последнюю неделю. Продолжайте в том же духе!",
                'action' => 'Посмотреть статистику',
                'action_url' => route('statistics.show'),
                'icon' => 'trophy',
            ];
        }

        if ($completedLastWeek === 0 && $user->tasks()->where('completed', false)->count() > 0) {
            return [
                'type' => 'productivity',
                'urgency' => 'medium',
                'title' => 'Время завершить задачи',
                'description' => 'Вы не завершили ни одной задачи за последнюю неделю. Давайте исправим это!',
                'action' => 'Активные задачи',
                'action_url' => route('tasks.index', ['filter' => 'pending']),
                'icon' => 'chart',
            ];
        }

        return null;
    }

    /**
     * Анализ использования тегов.
     *
     * @param User $user
     * @return array|null
     */
    private function analyzeTags(User $user): ?array
    {
        $tasksWithoutTags = $user->tasks()
            ->where('completed', false)
            ->doesntHave('tags')
            ->count();

        if ($tasksWithoutTags > 5) {
            return [
                'type' => 'tags',
                'urgency' => 'low',
                'title' => 'Используйте теги для лучшей организации',
                'description' => "У вас {$tasksWithoutTags} задач без тегов. Теги помогут лучше организовать работу.",
                'action' => 'Управление тегами',
                'action_url' => route('tags.index'),
                'icon' => 'tag',
            ];
        }

        return null;
    }

    /**
     * Предложить оптимальный приоритет для задачи.
     *
     * @param Task $task
     * @return string
     */
    public function suggestPriority(Task $task): string
    {
        // Если есть срок выполнения
        if ($task->due_date) {
            $daysUntilDue = now()->diffInDays($task->due_date, false);

            // Срочно (меньше 2 дней)
            if ($daysUntilDue < 2) {
                return 'high';
            }

            // Средний приоритет (2-7 дней)
            if ($daysUntilDue <= 7) {
                return 'medium';
            }
        }

        // По умолчанию низкий приоритет
        return 'low';
    }

    /**
     * Получить задачи, которые нужно выполнить сегодня.
     *
     * @param User $user
     * @return Collection
     */
    public function getTodayTasks(User $user): Collection
    {
        return $user->tasks()
            ->where('completed', false)
            ->where(function ($query) {
                $query->whereDate('due_date', today())
                      ->orWhere('priority', 'high');
            })
            ->orderBy('priority', 'desc')
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();
    }

    /**
     * Получить следующую рекомендуемую задачу для выполнения.
     *
     * @param User $user
     * @return Task|null
     */
    public function getNextTask(User $user): ?Task
    {
        $now = now()->toDateTimeString();
        $today = now()->toDateString();
        
        return $user->tasks()
            ->where('completed', false)
            ->orderByRaw("
                CASE 
                    WHEN due_date < ? THEN 1
                    WHEN DATE(due_date) = ? THEN 2
                    WHEN priority = 'high' THEN 3
                    WHEN priority = 'medium' THEN 4
                    ELSE 5
                END
            ", [$now, $today])
            ->orderBy('due_date', 'asc')
            ->first();
    }

    /**
     * Получить оценку производительности пользователя.
     *
     * @param User $user
     * @return array
     */
    public function getPerformanceScore(User $user): array
    {
        $totalTasks = $user->tasks()->count();
        $completedTasks = $user->tasks()->where('completed', true)->count();
        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        $completedOnTime = $user->tasks()
            ->where('completed', true)
            ->whereNotNull('due_date')
            ->whereRaw('updated_at <= due_date')
            ->count();

        $totalWithDueDate = $user->tasks()
            ->where('completed', true)
            ->whereNotNull('due_date')
            ->count();

        $onTimeRate = $totalWithDueDate > 0 ? round(($completedOnTime / $totalWithDueDate) * 100) : 0;

        // Расчет общего балла
        $score = round(($completionRate * 0.6) + ($onTimeRate * 0.4));

        return [
            'score' => $score,
            'completion_rate' => $completionRate,
            'on_time_rate' => $onTimeRate,
            'level' => $this->getPerformanceLevel($score),
            'badge' => $this->getPerformanceBadge($score),
        ];
    }

    /**
     * Определить уровень производительности.
     *
     * @param int $score
     * @return string
     */
    private function getPerformanceLevel(int $score): string
    {
        if ($score >= 90) return 'Отлично';
        if ($score >= 75) return 'Хорошо';
        if ($score >= 60) return 'Средне';
        if ($score >= 40) return 'Удовлетворительно';
        return 'Требует улучшения';
    }

    /**
     * Получить значок производительности.
     *
     * @param int $score
     * @return string
     */
    private function getPerformanceBadge(int $score): string
    {
        if ($score >= 90) return '🏆';
        if ($score >= 75) return '⭐';
        if ($score >= 60) return '👍';
        if ($score >= 40) return '📈';
        return '💪';
    }
}
