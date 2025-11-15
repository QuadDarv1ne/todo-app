<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\TaskHelper;
use App\Models\Task;
use App\Models\Donation;
use App\Services\TaskRecommendationService;

/**
 * Class DashboardController
 *
 * Контроллер для отображения панели управления пользователя.
 * Показывает статистику задач, последние задачи и графики активности.
 */
class DashboardController extends Controller
{
    public function __construct(private TaskRecommendationService $recommendationService)
    {
    }

    public function index(Request $request)
    {
        $user = $request->user();
        
        $stats = TaskHelper::getUserTaskStats($user);
        $recentTasks = TaskHelper::getRecentTasks($user, 5);
        
        // Get recommendations
        $recommendations = $this->recommendationService->getRecommendations($user);
        $nextTask = $this->recommendationService->getNextTask($user);
        $todayTasks = $this->recommendationService->getTodayTasks($user);
        $performance = $this->recommendationService->getPerformanceScore($user);
        
        // Get tasks for the chart - database agnostic approach
        $tasksLastWeek = $user->tasks()
            ->where('created_at', '>=', now()->subDays(7))
            ->get();
            
        // Group tasks by date on PHP side instead of using SQL DATE() function
        $tasksByDay = collect();
        foreach ($tasksLastWeek as $task) {
            $date = $task->created_at->format('Y-m-d');
            if (!$tasksByDay->has($date)) {
                $tasksByDay->put($date, [
                    'date' => $date,
                    'count' => 0
                ]);
            }
            $tasksByDay[$date]['count']++;
        }
        
        // Sort by date and convert to array
        $tasksByDay = $tasksByDay->sortBy('date')->values();
        
        // Get tasks by completion status
        $completionStats = [
            'completed' => $user->tasks()->where('completed', true)->count(),
            'pending' => $user->tasks()->where('completed', false)->count(),
        ];
        
        // Get donation statistics
        $donationStats = [
            'count' => Donation::getTotalDonationCount($user->id),
            'amount' => Donation::getTotalDonationAmount($user->id),
            'currencies' => Donation::where('user_id', $user->id)
                ->where('status', 'completed')
                ->distinct('currency')
                ->count('currency'),
        ];
        
        return view('user-dashboard', [
            'totalTasks' => $stats['total'],
            'completedTasks' => $stats['completed'],
            'pendingTasks' => $stats['pending'],
            'completionPercentage' => $stats['completion_percentage'],
            'recentTasks' => $recentTasks,
            'tasksByDay' => $tasksByDay,
            'completionStats' => $completionStats,
            'donationStats' => $donationStats,
            'recommendations' => $recommendations,
            'nextTask' => $nextTask,
            'todayTasks' => $todayTasks,
            'performance' => $performance,
        ]);
    }
}