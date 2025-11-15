<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(private NotificationService $notificationService)
    {
    }

    /**
     * Получить все непрочитанные уведомления.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $notifications = $this->notificationService->getUnreadNotifications(
            $request->user(),
            $request->get('limit', 10)
        );

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $request->user()->unreadNotifications->count(),
        ]);
    }

    /**
     * Отметить уведомление как прочитанное.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function markAsRead(Request $request, string $id): JsonResponse
    {
        $success = $this->notificationService->markAsRead($id, $request->user());

        if ($success) {
            return response()->json(['message' => 'Уведомление отмечено как прочитанное']);
        }

        return response()->json(['message' => 'Уведомление не найдено'], 404);
    }

    /**
     * Отметить все уведомления как прочитанные.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        $count = $this->notificationService->markAllAsRead($request->user());

        return response()->json([
            'message' => 'Все уведомления отмечены как прочитанные',
            'count' => $count,
        ]);
    }

    /**
     * Удалить уведомление.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        $success = $this->notificationService->deleteNotification($id, $request->user());

        if ($success) {
            return response()->json(['message' => 'Уведомление удалено']);
        }

        return response()->json(['message' => 'Уведомление не найдено'], 404);
    }

    /**
     * Отобразить страницу уведомлений.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        $notifications = $request->user()->notifications()->paginate(20);
        $unreadCount = $request->user()->unreadNotifications->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }
}
