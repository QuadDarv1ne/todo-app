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
 * - update() - обновляет существующий донат
 * - destroy() - удаляет донат
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
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    /**
     * Показать страницу "Мои донаты" с статистикой
     */
    public function myDonations()
    {
        try {
            $userId = Auth::id();
            
            // Получаем статистику по всем валютам
            $stats = Donation::getUserStats($userId);
            
            // Получаем последние донаты
            $recentDonations = Donation::getRecentDonations($userId, 10);
            
            return view('donations.my-donations', compact('stats', 'recentDonations'));
        } catch (\Exception $e) {
            Log::error('Error loading donations page: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ошибка при загрузке страницы донатов');
        }
    }

    /**
     * Создать новый донат
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'currency' => 'required|string|max:10',
                'amount' => 'required|numeric|min:0.01|max:1000000',
                'description' => 'nullable|string|max:500',
            ], [
                'currency.required' => 'Пожалуйста, выберите валюту',
                'currency.max' => 'Валюта не может быть длиннее 10 символов',
                'amount.required' => 'Пожалуйста, укажите сумму',
                'amount.numeric' => 'Сумма должна быть числом',
                'amount.min' => 'Сумма должна быть больше 0',
                'amount.max' => 'Сумма не может превышать 1,000,000',
                'description.max' => 'Описание не может превышать 500 символов',
            ]);

            $donation = Donation::create([
                'user_id' => Auth::id(),
                'currency' => $validated['currency'],
                'amount' => $validated['amount'],
                'description' => $validated['description'] ?? null,
                'status' => 'completed',
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Донат успешно создан!',
                    'donation' => $donation
                ]);
            }

            return redirect()->route('donations.my')
                ->with('success', 'Донат успешно создан!');
        } catch (\Exception $e) {
            Log::error('Error creating donation: ' . $e->getMessage());
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка при создании доната: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Ошибка при создании доната: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Обновить донат
     */
    public function update(Request $request, Donation $donation)
    {
        try {
            // Проверяем, что донат принадлежит текущему пользователю
            if ($donation->user_id !== Auth::id()) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'У вас нет прав для редактирования этого доната'
                    ], 403);
                }
                
                return redirect()->back()->with('error', 'У вас нет прав для редактирования этого доната');
            }

            $validated = $request->validate([
                'currency' => 'required|string|max:10',
                'amount' => 'required|numeric|min:0.01|max:1000000',
                'description' => 'nullable|string|max:500',
            ], [
                'currency.required' => 'Пожалуйста, выберите валюту',
                'currency.max' => 'Валюта не может быть длиннее 10 символов',
                'amount.required' => 'Пожалуйста, укажите сумму',
                'amount.numeric' => 'Сумма должна быть числом',
                'amount.min' => 'Сумма должна быть больше 0',
                'amount.max' => 'Сумма не может превышать 1,000,000',
                'description.max' => 'Описание не может превышать 500 символов',
            ]);

            $donation->update([
                'currency' => $validated['currency'],
                'amount' => $validated['amount'],
                'description' => $validated['description'] ?? null,
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Донат успешно обновлён!',
                    'donation' => $donation
                ]);
            }

            return redirect()->route('donations.my')
                ->with('success', 'Донат успешно обновлён!');
        } catch (\Exception $e) {
            Log::error('Error updating donation: ' . $e->getMessage());
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка при обновлении доната: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Ошибка при обновлении доната: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Удалить донат
     */
    public function destroy(Request $request, Donation $donation)
    {
        try {
            // Проверяем, что донат принадлежит текущему пользователю
            if ($donation->user_id !== Auth::id()) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'У вас нет прав для удаления этого доната'
                    ], 403);
                }
                
                return redirect()->back()->with('error', 'У вас нет прав для удаления этого доната');
            }

            $donation->delete();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Донат успешно удалён!'
                ]);
            }

            return redirect()->route('donations.my')
                ->with('success', 'Донат успешно удалён!');
        } catch (\Exception $e) {
            Log::error('Error deleting donation: ' . $e->getMessage());
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка при удалении доната: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Ошибка при удалении доната: ' . $e->getMessage());
        }
    }

    /**
     * API метод для получения статистики
     */
    public function apiStats(Request $request)
    {
        try {
            $currency = $request->input('currency');
            $userId = Auth::id();

            if ($currency) {
                $stats = Donation::getStatsByCurrency($currency, $userId);
                return response()->json($stats);
            }

            $stats = Donation::getUserStats($userId);
            return response()->json($stats);
        } catch (\Exception $e) {
            Log::error('Error fetching donation stats: ' . $e->getMessage());
            return response()->json([
                'error' => 'Ошибка при получении статистики'
            ], 500);
        }
    }
}