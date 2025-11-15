<?php

/**
 * Модель Donation
 * 
 * Представляет собой донат (пожертвование) от пользователя в системе.
 * Содержит методы для получения статистики по донатам с использованием
 * Laravel Aggregation функций.
 * 
 * Основные возможности:
 * - Связь с моделью User (belongs to)
 * - Получение статистики по конкретной валюте (count, sum, avg, min, max)
 * - Получение сводной статистики для пользователя по всем валютам
 * - Группировка данных с использованием groupBy
 * 
 * Методы агрегации:
 * @method static getStatsByCurrency(string $currency, ?int $userId = null) - статистика по валюте
 * @method static getUserStats(int $userId) - статистика пользователя по всем валютам
 * 
 * @property int $id
 * @property int $user_id
 * @property string $currency
 * @property float $amount
 * @property string $status
 * @property string|null $description
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'currency',
        'amount',
        'status',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:8',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить статистику по валюте
     */
    public static function getStatsByCurrency(string $currency, ?int $userId = null)
    {
        $query = self::where('currency', $currency)
            ->where('status', 'completed');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return [
            'count' => $query->count(),
            'total' => $query->sum('amount'),
            'average' => $query->avg('amount'),
            'min' => $query->min('amount'),
            'max' => $query->max('amount'),
        ];
    }

    /**
     * Получить статистику по всем валютам для пользователя
     */
    public static function getUserStats(int $userId)
    {
        return self::select(
                'currency',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as total'),
                DB::raw('AVG(amount) as average'),
                DB::raw('MIN(amount) as min'),
                DB::raw('MAX(amount) as max')
            )
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->groupBy('currency')
            ->get();
    }
}