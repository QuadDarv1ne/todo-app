<?php

/**
 * Миграция для создания таблицы donations
 * 
 * Эта миграция создаёт таблицу для хранения информации о донатах пользователей.
 * Таблица поддерживает различные валюты (BTC, USD, EUR и т.д.) и содержит
 * все необходимые поля для расчёта статистики.
 * 
 * Поля:
 * - user_id: связь с пользователем
 * - currency: валюта доната (BTC, USD, EUR и т.д.)
 * - amount: сумма доната (decimal для точности)
 * - status: статус транзакции (completed, pending, failed)
 * - description: описание/комментарий к донату
 * 
 * Индексы созданы для оптимизации запросов агрегации по валютам и пользователям.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('currency', 10); // BTC, USD, EUR и т.д.
            $table->decimal('amount', 15, 8);
            $table->string('status')->default('completed'); // completed, pending, failed
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Индексы для быстрых агрегаций
            $table->index(['user_id', 'currency']);
            $table->index('currency');
        });
    }

    public function down()
    {
        Schema::dropIfExists('donations');
    }
};