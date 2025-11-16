<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->boolean('is_recurring')->default(false)->after('reminders_enabled');
            $table->enum('recurrence_type', ['daily', 'weekly', 'monthly', 'yearly'])->nullable()->after('is_recurring');
            $table->integer('recurrence_interval')->default(1)->after('recurrence_type'); // Каждые N дней/недель/месяцев
            $table->date('recurrence_end_date')->nullable()->after('recurrence_interval');
            $table->timestamp('last_recurrence_date')->nullable()->after('recurrence_end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['is_recurring', 'recurrence_type', 'recurrence_interval', 'recurrence_end_date', 'last_recurrence_date']);
        });
    }
};
