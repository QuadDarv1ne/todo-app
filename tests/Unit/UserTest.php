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
     * Тест: email_verified_at приводится к datetime.
     */
    public function test_email_verified_at_is_cast_to_datetime(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now()
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->email_verified_at);
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
    }
}