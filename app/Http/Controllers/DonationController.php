<?php

/**
 * DonationController
 * 
 * Контроллер для управления донатами и отображения статистики.
 * Обрабатывает запросы на просмотр статистики, создание новых донатов
 * и предоставляет API эндпоинт для получения данных.
 * 
 * Основные методы:
 * - myDonations() - отображает страницу "Мои донаты" со статистикой по всем валютам
 * - store() - создаёт новый донат с валидацией данных
 * - apiStats() - API метод для получения статистики в JSON формате
 * 
 * Используемые агрегирующие функции:
 * - getUserStats() - получает count, sum, avg, min, max для каждой валюты
 * - groupBy('currency') - группирует результаты по валютам
 * 
 * Требует аутентификации пользователя (middleware: auth)
 */

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    /**
     * Показать страницу "Мои донаты" с статистикой
     */
    public function myDonations()
    {
        $userId = Auth::id();
        
        // Получаем статистику по всем валютам
        $stats = Donation::getUserStats($userId);
        
        // Получаем последние донаты
        $recentDonations = Donation::where('user_id', $userId)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('donations.my-donations', compact('stats', 'recentDonations'));
    }

    /**
     * Создать новый донат
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'currency' => 'required|string|max:10',
            'amount' => 'required|numeric|min:0.01|max:1000000',
            'description' => 'nullable|string|max:500',
        ]);

        $donation = Donation::create([
            'user_id' => Auth::id(),
            'currency' => $validated['currency'],
            'amount' => $validated['amount'],
            'description' => $validated['description'] ?? null,
            'status' => 'completed',
        ]);

        return redirect()->route('donations.my')
            ->with('success', 'Донат успешно создан!');
    }

    /**
     * API метод для получения статистики
     */
    public function apiStats(Request $request)
    {
        $currency = $request->input('currency');
        $userId = Auth::id();

        if ($currency) {
            $stats = Donation::getStatsByCurrency($currency, $userId);
            return response()->json($stats);
        }

        $stats = Donation::getUserStats($userId);
        return response()->json($stats);
    }
}