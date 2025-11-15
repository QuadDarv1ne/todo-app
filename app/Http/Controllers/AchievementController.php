<?php

namespace App\Http\Controllers;

use App\Services\AchievementService;
use Illuminate\Http\Request;
use App\Models\Achievement;

class AchievementController extends Controller
{
    public function __construct(private AchievementService $achievementService)
    {
    }

    /**
     * Показать все достижения.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $achievements = Achievement::orderBy('category')
            ->orderBy('points')
            ->get();

        // Группируем достижения по категориям
        $achievementsByCategory = $achievements->groupBy('category');

        return view('achievements.index', compact('achievements', 'achievementsByCategory'));
    }

    /**
     * Получить прогресс пользователя (API).
     */
    public function progress(Request $request)
    {
        $user = $request->user();
        $progress = $this->achievementService->getUserProgress($user);
        
        return response()->json($progress);
    }

    /**
     * Проверить и разблокировать достижения вручную.
     */
    public function check(Request $request)
    {
        $user = $request->user();
        $unlockedAchievements = $this->achievementService->checkAndUnlockAchievements($user);
        
        return response()->json([
            'success' => true,
            'unlocked' => $unlockedAchievements,
            'count' => count($unlockedAchievements),
        ]);
    }
}
