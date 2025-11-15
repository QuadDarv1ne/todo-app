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
        
        $userAchievements = $this->achievementService->getUserAchievements($user);
        $userProgress = $this->achievementService->getUserProgress($user);
        
        $allAchievements = Achievement::public()
            ->orderBy('category')
            ->orderBy('points')
            ->get()
            ->map(function ($achievement) use ($user) {
                $achievement->is_unlocked = $achievement->isUnlockedBy($user);
                return $achievement;
            });

        return view('achievements.index', compact('allAchievements', 'userAchievements', 'userProgress'));
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
