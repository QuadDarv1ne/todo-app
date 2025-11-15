<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\SendTaskReminders::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Send task reminders daily at 9:00 AM
        $schedule->command('tasks:send-reminders --days=1')
                 ->dailyAt('09:00')
                 ->description('Send task reminders for tasks due tomorrow');

        // Send task reminders for tasks due in 3 days
        $schedule->command('tasks:send-reminders --days=3')
                 ->dailyAt('09:00')
                 ->description('Send task reminders for tasks due in 3 days');

        // Send task reminders for tasks due in 1 week
        $schedule->command('tasks:send-reminders --days=7')
                 ->dailyAt('09:00')
                 ->description('Send task reminders for tasks due in 1 week');

        // Send overdue task reminders daily at 9:30 AM
        $schedule->command('tasks:send-reminders')
                 ->dailyAt('09:30')
                 ->description('Send reminders for overdue tasks');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}