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
        // Run reminders every minute; NotificationService фильтрует по личному времени пользователя и кэширует, чтобы не дублировать в пределах дня
        $schedule->command('tasks:send-reminders --days=1')
             ->everyMinute()
             ->description('Send task reminders for tasks due tomorrow (per-user time)');

        $schedule->command('tasks:send-reminders --days=3')
             ->everyMinute()
             ->description('Send task reminders for tasks due in 3 days (per-user time)');

        $schedule->command('tasks:send-reminders --days=7')
             ->everyMinute()
             ->description('Send task reminders for tasks due in 1 week (per-user time)');

        $schedule->command('tasks:send-reminders')
             ->everyMinute()
             ->description('Send reminders for overdue tasks (per-user time)');
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