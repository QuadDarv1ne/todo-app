<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\TaskHelper;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $stats = TaskHelper::getUserTaskStats($user);
        $recentTasks = TaskHelper::getRecentTasks($user, 5);
        
        return view('dashboard', [
            'totalTasks' => $stats['total'],
            'completedTasks' => $stats['completed'],
            'pendingTasks' => $stats['pending'],
            'completionPercentage' => $stats['completion_percentage'],
            'recentTasks' => $recentTasks
        ]);
    }
}