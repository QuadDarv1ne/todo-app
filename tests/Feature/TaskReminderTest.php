<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use App\Notifications\TaskDueReminder;
use App\Services\NotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TaskReminderTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_sends_reminder_for_tasks_due_tomorrow()
    {
        Notification::fake();

        // Create a task due tomorrow
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'due_date' => now()->addDay(),
            'reminders_enabled' => true
        ]);

        // Enable user reminders
        $this->user->update([
            'reminder_enabled' => true,
            'reminder_1_day' => true
        ]);

        // Run the notification service
        $notificationService = new NotificationService();
        $count = $notificationService->sendTaskDueReminders(1);

        // Assert that one reminder was sent
        $this->assertEquals(1, $count);

        // Assert that the notification was sent
        Notification::assertSentTo($this->user, TaskDueReminder::class);
    }

    /** @test */
    public function it_does_not_send_reminder_when_user_reminders_are_disabled()
    {
        Notification::fake();

        // Create a task due tomorrow
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'due_date' => now()->addDay(),
            'reminders_enabled' => true
        ]);

        // Disable user reminders
        $this->user->update([
            'reminder_enabled' => false,
            'reminder_1_day' => true
        ]);

        // Run the notification service
        $notificationService = new NotificationService();
        $count = $notificationService->sendTaskDueReminders(1);

        // Assert that no reminders were sent
        $this->assertEquals(0, $count);

        // Assert that no notification was sent
        Notification::assertNothingSent();
    }

    /** @test */
    public function it_does_not_send_reminder_when_task_reminders_are_disabled()
    {
        Notification::fake();

        // Create a task due tomorrow with reminders disabled
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'due_date' => now()->addDay(),
            'reminders_enabled' => false
        ]);

        // Enable user reminders
        $this->user->update([
            'reminder_enabled' => true,
            'reminder_1_day' => true
        ]);

        // Run the notification service
        $notificationService = new NotificationService();
        $count = $notificationService->sendTaskDueReminders(1);

        // Assert that no reminders were sent
        $this->assertEquals(0, $count);

        // Assert that no notification was sent
        Notification::assertNothingSent();
    }

    /** @test */
    public function it_sends_overdue_reminders()
    {
        Notification::fake();

        // Create an overdue task
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'due_date' => now()->subDay(),
            'completed' => false,
            'reminders_enabled' => true
        ]);

        // Enable user reminders for overdue tasks
        $this->user->update([
            'reminder_enabled' => true,
            'reminder_overdue' => true
        ]);

        // Run the notification service
        $notificationService = new NotificationService();
        $count = $notificationService->sendOverdueTaskReminders();

        // Assert that one reminder was sent
        $this->assertEquals(1, $count);

        // Assert that the notification was sent
        Notification::assertSentTo($this->user, TaskDueReminder::class);
    }
}