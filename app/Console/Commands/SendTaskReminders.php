<?php

namespace App\Console\Commands;

use App\Services\NotificationService;
use Illuminate\Console\Command;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-reminders {--days=1 : Days before due date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send task due date reminders to users';

    /**
     * Execute the console command.
     */
    public function handle(NotificationService $notificationService): int
    {
        $days = (int) $this->option('days');
        
        if ($days > 0) {
            $this->info("Sending task reminders for tasks due in {$days} day(s)...");
            
            $count = $notificationService->sendTaskDueReminders($days);
            
            $this->info("Sent {$count} reminder(s) successfully!");
        } else {
            // Send overdue task reminders
            $this->info("Sending overdue task reminders...");
            
            $overdueCount = $notificationService->sendOverdueTaskReminders();
            
            $this->info("Sent {$overdueCount} overdue reminder(s) successfully!");
        }
        
        return self::SUCCESS;
    }
}