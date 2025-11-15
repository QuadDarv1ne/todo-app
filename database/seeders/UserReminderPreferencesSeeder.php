<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserReminderPreferencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update all existing users with default reminder preferences
        User::whereNull('reminder_enabled')->update([
            'reminder_enabled' => true,
            'reminder_1_day' => true,
            'reminder_3_days' => true,
            'reminder_1_week' => true,
            'reminder_overdue' => true,
            'reminder_time' => '09:00:00'
        ]);
    }
}