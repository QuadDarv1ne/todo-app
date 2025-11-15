<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Notifications\TaskLimitApproaching;
use Illuminate\Support\Facades\Notification;

class UserObserverTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_sends_notification_when_user_approaches_task_limit()
    {
        Notification::fake();
        
        $user = User::factory()->create([
            'task_limit' => 10,
        ]);
        
        // Создаем 9 задач (90% от лимита)
        \App\Models\Task::factory()->count(9)->create([
            'user_id' => $user->id
        ]);
        
        // Обновляем пользователя для срабатывания observer
        $user->update(['name' => 'Updated Name']);
        
        Notification::assertSentTo(
            $user,
            TaskLimitApproaching::class,
            function ($notification, $channels) use ($user) {
                return $notification->remaining === 1; // 10 - 9 = 1 задача осталась
            }
        );
    }

    /** @test */
    public function it_cleans_bio_html_tags()
    {
        $user = User::factory()->create([
            'bio' => '<script>alert("xss")</script>Чистая биография',
        ]);
        
        $this->assertEquals('alert("xss")Чистая биография', $user->bio);
    }

    /** @test */
    public function it_normalizes_email()
    {
        $user = User::factory()->create([
            'email' => 'TEST@EXAMPLE.COM',
        ]);
        
        $this->assertEquals('test@example.com', $user->email);
    }
}