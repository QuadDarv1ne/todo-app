<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReminderController extends Controller
{
    /**
     * Получить настройки напоминаний пользователя.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        
        return response()->json([
            'success' => true,
            'settings' => [
                'reminder_enabled' => $user->reminder_enabled,
                'reminder_1_day' => $user->reminder_1_day,
                'reminder_3_days' => $user->reminder_3_days,
                'reminder_1_week' => $user->reminder_1_week,
                'reminder_overdue' => $user->reminder_overdue,
                'reminder_time' => $user->reminder_time ? $user->reminder_time->format('H:i') : '09:00',
            ]
        ]);
    }

    /**
     * Обновить настройки напоминаний пользователя.
     */
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'reminder_enabled' => 'boolean',
            'reminder_1_day' => 'boolean',
            'reminder_3_days' => 'boolean',
            'reminder_1_week' => 'boolean',
            'reminder_overdue' => 'boolean',
            'reminder_time' => 'nullable|date_format:H:i',
        ]);

        $user = $request->user();
        
        $user->update($request->only([
            'reminder_enabled',
            'reminder_1_day',
            'reminder_3_days',
            'reminder_1_week',
            'reminder_overdue',
            'reminder_time'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Настройки напоминаний успешно обновлены',
            'settings' => [
                'reminder_enabled' => $user->reminder_enabled,
                'reminder_1_day' => $user->reminder_1_day,
                'reminder_3_days' => $user->reminder_3_days,
                'reminder_1_week' => $user->reminder_1_week,
                'reminder_overdue' => $user->reminder_overdue,
                'reminder_time' => $user->reminder_time ? $user->reminder_time->format('H:i') : '09:00',
            ]
        ]);
    }
}