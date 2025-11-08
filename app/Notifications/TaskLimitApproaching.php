<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskLimitApproaching extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Количество оставшихся задач
     */
    public $remaining;

    /**
     * Create a new notification instance.
     */
    public function __construct(int $remaining)
    {
        $this->remaining = $remaining;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database']; // Можно добавить 'broadcast' для уведомлений в реальном времени
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Вы приближаетесь к лимиту задач')
            ->greeting('Здравствуйте, ' . $notifiable->name . '!')
            ->line('Вы использовали почти все доступные задачи в вашем аккаунте.')
            ->line('Осталось: ' . $this->remaining . ' задач')
            ->action('Перейти в профиль', url('/profile'))
            ->line('Если вам нужен больший лимит, обратитесь к администратору.')
            ->salutation('С уважением, Команда ' . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'task_limit_approaching',
            'message' => 'Вы приближаетесь к лимиту задач. Осталось: ' . $this->remaining . ' задач',
            'remaining' => $this->remaining,
            'user_id' => $notifiable->id,
        ];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return $this->toArray($notifiable);
    }
}