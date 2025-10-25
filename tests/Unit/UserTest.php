<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест: пользователь может быть создан с базовыми атрибутами.
     */
    public function test_user_can_be_created_with_basic_attributes(): void
    {
        $user = User::factory()->create([
            'name' => 'Иван Иванов',
            'email' => 'ivan@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Иван Иванов',
            'email' => 'ivan@example.com',
        ]);
        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * Тест: пароль автоматически хэшируется.
     */
    public function test_password_is_automatically_hashed(): void
    {
        $user = User::factory()->create([
            'password' => 'plain-password',
        ]);

        $this->assertNotEquals('plain-password', $user->password);
        $this->assertTrue(password_verify('plain-password', $user->password));
    }

    /**
     * Тест: скрытые поля не включаются в массив.
     */
    public function test_hidden_fields_are_not_included_in_array(): void
    {
        $user = User::factory()->create();
        $array = $user->toArray();

        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
    }

    /**
     * Тест: отношение tasks возвращает коллекцию задач.
     */
    public function test_tasks_relationship_returns_tasks_collection(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(3)->create(['user_id' => $user->id]);

        $this->assertCount(3, $user->tasks);
        $this->assertInstanceOf(Task::class, $user->tasks->first());
    }

    /**
     * Тест: task_count возвращает правильное количество задач.
     */
    public function test_task_count_attribute_returns_correct_count(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(5)->create(['user_id' => $user->id]);

        $this->assertEquals(5, $user->task_count);
    }

    /**
     * Тест: task_count возвращает 0 для пользователя без задач.
     */
    public function test_task_count_returns_zero_when_no_tasks(): void
    {
        $user = User::factory()->create();

        $this->assertEquals(0, $user->task_count);
    }

    /**
     * Тест: completed_task_count возвращает правильное количество завершённых задач.
     */
    public function test_completed_task_count_returns_correct_count(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(3)->create([
            'user_id' => $user->id,
            'completed' => true
        ]);
        Task::factory()->count(2)->create([
            'user_id' => $user->id,
            'completed' => false
        ]);

        $this->assertEquals(3, $user->completed_task_count);
    }

    /**
     * Тест: pending_task_count возвращает правильное количество активных задач.
     */
    public function test_pending_task_count_returns_correct_count(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(4)->create([
            'user_id' => $user->id,
            'completed' => false
        ]);
        Task::factory()->count(1)->create([
            'user_id' => $user->id,
            'completed' => true
        ]);

        $this->assertEquals(4, $user->pending_task_count);
    }

    /**
     * Тест: completion_percentage рассчитывается правильно.
     */
    public function test_completion_percentage_calculates_correctly(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(6)->create([
            'user_id' => $user->id,
            'completed' => true
        ]);
        Task::factory()->count(4)->create([
            'user_id' => $user->id,
            'completed' => false
        ]);

        // 6 из 10 = 60%
        $this->assertEquals(60.0, $user->completion_percentage);
    }

    /**
     * Тест: completion_percentage возвращает 0 при отсутствии задач.
     */
    public function test_completion_percentage_returns_zero_when_no_tasks(): void
    {
        $user = User::factory()->create();

        $this->assertEquals(0, $user->completion_percentage);
    }

    /**
     * Тест: completion_percentage округляется до 2 знаков.
     */
    public function test_completion_percentage_rounds_to_two_decimals(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(1)->create([
            'user_id' => $user->id,
            'completed' => true
        ]);
        Task::factory()->count(2)->create([
            'user_id' => $user->id,
            'completed' => false
        ]);

        // 1 из 3 = 33.33%
        $this->assertEquals(33.33, $user->completion_percentage);
    }

    /**
     * Тест: getRecentTasks возвращает последние задачи в правильном порядке.
     */
    public function test_get_recent_tasks_returns_latest_tasks_in_order(): void
    {
        $user = User::factory()->create();
        
        $oldTask = Task::factory()->create([
            'user_id' => $user->id,
            'created_at' => now()->subDays(5)
        ]);
        $newTask = Task::factory()->create([
            'user_id' => $user->id,
            'created_at' => now()
        ]);
        $middleTask = Task::factory()->create([
            'user_id' => $user->id,
            'created_at' => now()->subDays(2)
        ]);

        $recentTasks = $user->getRecentTasks(3);

        $this->assertCount(3, $recentTasks);
        $this->assertEquals($newTask->id, $recentTasks[0]->id);
        $this->assertEquals($middleTask->id, $recentTasks[1]->id);
        $this->assertEquals($oldTask->id, $recentTasks[2]->id);
    }

    /**
     * Тест: getRecentTasks ограничивает количество возвращаемых задач.
     */
    public function test_get_recent_tasks_limits_result_count(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(10)->create(['user_id' => $user->id]);

        $recentTasks = $user->getRecentTasks(3);

        $this->assertCount(3, $recentTasks);
    }

    /**
     * Тест: getRecentTasks использует лимит по умолчанию (5 задач).
     */
    public function test_get_recent_tasks_uses_default_limit(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(10)->create(['user_id' => $user->id]);

        $recentTasks = $user->getRecentTasks();

        $this->assertCount(5, $recentTasks);
    }

    /**
     * Тест: задачи не смешиваются между разными пользователями.
     */
    public function test_tasks_are_isolated_between_users(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        Task::factory()->count(3)->create(['user_id' => $user1->id]);
        Task::factory()->count(2)->create(['user_id' => $user2->id]);

        $this->assertCount(3, $user1->tasks);
        $this->assertCount(2, $user2->tasks);
        $this->assertEquals(3, $user1->task_count);
        $this->assertEquals(2, $user2->task_count);
    }

    /**
     * Тест: email_verified_at приводится к datetime.
     */
    public function test_email_verified_at_is_cast_to_datetime(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now()
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->email_verified_at);
    }
}