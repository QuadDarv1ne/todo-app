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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('reminder_enabled')->default(true)->after('email');
            $table->boolean('reminder_1_day')->default(true)->after('reminder_enabled');
            $table->boolean('reminder_3_days')->default(true)->after('reminder_1_day');
            $table->boolean('reminder_1_week')->default(true)->after('reminder_3_days');
            $table->boolean('reminder_overdue')->default(true)->after('reminder_1_week');
            $table->time('reminder_time')->default('09:00:00')->after('reminder_overdue');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'reminder_enabled',
                'reminder_1_day',
                'reminder_3_days',
                'reminder_1_week',
                'reminder_overdue',
                'reminder_time'
            ]);
        });
    }
};