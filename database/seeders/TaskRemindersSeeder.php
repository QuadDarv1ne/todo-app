<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskRemindersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update all existing tasks with default reminder settings
        Task::whereNull('reminders_enabled')->update([
            'reminders_enabled' => true
        ]);
    }
}