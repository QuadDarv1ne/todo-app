<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\TaskHelper;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $stats = TaskHelper::getUserTaskStats($user);
        $recentTasks = TaskHelper::getRecentTasks($user, 5);
        
        // Get tasks for the chart
        $tasksByDay = $user->tasks()
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Get tasks by completion status
        $completionStats = [
            'completed' => $user->tasks()->where('completed', true)->count(),
            'pending' => $user->tasks()->where('completed', false)->count(),
        ];
        
        return view('user-dashboard', [
            'totalTasks' => $stats['total'],
            'completedTasks' => $stats['completed'],
            'pendingTasks' => $stats['pending'],
            'completionPercentage' => $stats['completion_percentage'],
            'recentTasks' => $recentTasks,
            'tasksByDay' => $tasksByDay,
            'completionStats' => $completionStats
        ]);
    }
}