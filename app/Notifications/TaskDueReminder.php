<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDueReminder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Task $task)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $daysUntilDue = now()->diffInDays($this->task->due_date, false);
        
        if ($daysUntilDue < 0) {
            $subject = 'Задача просрочена: ' . $this->task->title;
            $greeting = 'Внимание! Задача просрочена';
            $message = 'Ваша задача "' . $this->task->title . '" просрочена на ' . abs($daysUntilDue) . ' дн.';
            $description = $this->task->description ? ('Описание: ' . $this->task->description) : '';
        } else {
            $subject = 'Напоминание о задаче: ' . $this->task->title;
            $greeting = 'Напоминание о задаче';
            $message = 'Срок выполнения задачи "' . $this->task->title . '" истекает через ' . $daysUntilDue . ' дн.';
            $description = $this->task->description ? ('Описание: ' . $this->task->description) : '';
        }

        $mail = (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line($message)
            ->line('Приоритет: ' . $this->task->priority_name)
            ->line('Срок: ' . $this->task->due_date->format('d.m.Y'));

        if ($description) {
            $mail->line($description);
        }

        return $mail->action('Просмотреть задачу', route('tasks.show', $this->task))
            ->line('Спасибо за использование нашего приложения!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'task_description' => $this->task->description,
            'due_date' => $this->task->due_date->toDateTimeString(),
            'priority' => $this->task->priority,
            'priority_name' => $this->task->priority_name,
            'is_overdue' => $this->task->is_overdue,
            'days_until_due' => now()->diffInDays($this->task->due_date, false),
            'message' => 'Срок выполнения задачи "' . $this->task->title . '" приближается',
        ];
    }
}