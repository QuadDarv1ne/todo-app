<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'reminder_enabled')) {
                $table->boolean('reminder_enabled')->default(true)->after('avatar_path');
            }
            if (!Schema::hasColumn('users', 'reminder_1_day')) {
                $table->boolean('reminder_1_day')->default(true)->after('reminder_enabled');
            }
            if (!Schema::hasColumn('users', 'reminder_3_days')) {
                $table->boolean('reminder_3_days')->default(true)->after('reminder_1_day');
            }
            if (!Schema::hasColumn('users', 'reminder_1_week')) {
                $table->boolean('reminder_1_week')->default(false)->after('reminder_3_days');
            }
            if (!Schema::hasColumn('users', 'reminder_overdue')) {
                $table->boolean('reminder_overdue')->default(true)->after('reminder_1_week');
            }
            if (!Schema::hasColumn('users', 'reminder_time')) {
                $table->time('reminder_time')->nullable()->after('reminder_overdue');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $cols = [
                'reminder_enabled', 'reminder_1_day', 'reminder_3_days',
                'reminder_1_week', 'reminder_overdue', 'reminder_time'
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
