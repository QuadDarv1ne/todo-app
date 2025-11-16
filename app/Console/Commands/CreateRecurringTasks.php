<?php

namespace App\Console\Commands;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateRecurringTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:create-recurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создать повторяющиеся задачи на основе расписания';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Проверка повторяющихся задач...');

        $recurringTasks = Task::where('is_recurring', true)
            ->where(function($q) {
                $q->whereNull('recurrence_end_date')
                  ->orWhere('recurrence_end_date', '>=', now());
            })
            ->get();

        $created = 0;

        foreach ($recurringTasks as $task) {
            if ($this->shouldCreateNextOccurrence($task)) {
                $this->createNextOccurrence($task);
                $created++;
            }
        }

        $this->info("Создано задач: $created");
        return 0;
    }

    protected function shouldCreateNextOccurrence(Task $task): bool
    {
        // Если задача ещё не создавалась
        if (!$task->last_recurrence_date) {
            return true;
        }

        $lastDate = Carbon::parse($task->last_recurrence_date);
        $now = now();

        switch ($task->recurrence_type) {
            case 'daily':
                return $lastDate->addDays($task->recurrence_interval ?? 1)->lte($now);
            case 'weekly':
                return $lastDate->addWeeks($task->recurrence_interval ?? 1)->lte($now);
            case 'monthly':
                return $lastDate->addMonths($task->recurrence_interval ?? 1)->lte($now);
            case 'yearly':
                return $lastDate->addYears($task->recurrence_interval ?? 1)->lte($now);
            default:
                return false;
        }
    }

    protected function createNextOccurrence(Task $task): void
    {
        $nextDate = $this->calculateNextDate($task);

        $newTask = $task->replicate();
        $newTask->completed = false;
        $newTask->is_recurring = false; // Копия не повторяется
        $newTask->due_date = $nextDate;
        $newTask->created_at = now();
        $newTask->updated_at = now();
        $newTask->save();

        // Обновить дату последнего создания
        $task->last_recurrence_date = now();
        $task->save();

        $this->line("Создана задача: {$newTask->title} (срок: {$nextDate->format('Y-m-d')})");
    }

    protected function calculateNextDate(Task $task): Carbon
    {
        $baseDate = $task->last_recurrence_date 
            ? Carbon::parse($task->last_recurrence_date) 
            : ($task->due_date ? Carbon::parse($task->due_date) : now());

        switch ($task->recurrence_type) {
            case 'daily':
                return $baseDate->addDays($task->recurrence_interval ?? 1);
            case 'weekly':
                return $baseDate->addWeeks($task->recurrence_interval ?? 1);
            case 'monthly':
                return $baseDate->addMonths($task->recurrence_interval ?? 1);
            case 'yearly':
                return $baseDate->addYears($task->recurrence_interval ?? 1);
            default:
                return now();
        }
    }
}
