<?php

namespace App\Http\Controllers;

use App\Helpers\TaskHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    /**
     * Получить статистику пользователя.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        
        $stats = [
            'basic' => TaskHelper::getUserTaskStats($user),
            'advanced' => TaskHelper::getAdvancedStats($user),
            'tags' => TaskHelper::getTagStats($user),
            'by_day_of_week' => TaskHelper::getTasksByDayOfWeek($user),
        ];

        return response()->json($stats);
    }

    /**
     * Отобразить страницу статистики.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        $user = $request->user();
        
        $stats = [
            'basic' => TaskHelper::getUserTaskStats($user),
            'advanced' => TaskHelper::getAdvancedStats($user),
            'tags' => TaskHelper::getTagStats($user),
            'by_day_of_week' => TaskHelper::getTasksByDayOfWeek($user),
        ];

        return view('statistics.index', compact('stats'));
    }
}
