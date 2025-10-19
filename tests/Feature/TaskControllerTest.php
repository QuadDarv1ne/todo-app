<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function authenticated_user_can_view_their_tasks()
    {
        $this->actingAs($this->user);
        
        $tasks = Task::factory()->count(3)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertViewHas('tasks');
        $this->assertCount(3, $response->viewData('tasks'));
    }

    /** @test */
    public function unauthenticated_user_cannot_view_tasks()
    {
        $response = $this->get(route('tasks.index'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_create_a_new_task()
    {
        $this->actingAs($this->user);

        $response = $this->postJson(route('tasks.store'), [
            'title' => 'Новая задача',
            'description' => 'Описание задачи'
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'task' => [
                'title' => 'Новая задача',
                'description' => 'Описание задачи',
                'completed' => false
            ]
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Новая задача',
            'description' => 'Описание задачи',
            'user_id' => $this->user->id
        ]);
    }

    /** @test */
    public function user_can_update_task_status()
    {
        $this->actingAs($this->user);
        
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'completed' => false
        ]);

        $response = $this->patchJson(route('tasks.update', $task), [
            'completed' => true
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'task' => [
                'completed' => true
            ]
        ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'completed' => true
        ]);
    }

    /** @test */
    public function user_can_update_task_title()
    {
        $this->actingAs($this->user);
        
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Старое название'
        ]);

        $response = $this->patchJson(route('tasks.update', $task), [
            'title' => 'Новое название'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'task' => [
                'title' => 'Новое название'
            ]
        ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Новое название'
        ]);
    }

    /** @test */
    public function user_can_update_task_description()
    {
        $this->actingAs($this->user);
        
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'description' => null
        ]);

        $response = $this->patchJson(route('tasks.update', $task), [
            'description' => 'Новое описание'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'task' => [
                'description' => 'Новое описание'
            ]
        ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'description' => 'Новое описание'
        ]);
    }

    /** @test */
    public function user_can_delete_their_task()
    {
        $this->actingAs($this->user);
        
        $task = Task::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->deleteJson(route('tasks.destroy', $task));

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }

    /** @test */
    public function user_cannot_update_another_users_task()
    {
        $this->actingAs($this->user);
        
        $otherUser = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $otherUser->id
        ]);

        $response = $this->patchJson(route('tasks.update', $task), [
            'completed' => true
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function user_cannot_delete_another_users_task()
    {
        $this->actingAs($this->user);
        
        $otherUser = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $otherUser->id
        ]);

        $response = $this->deleteJson(route('tasks.destroy', $task));

        $response->assertStatus(403);
    }

    /** @test */
    public function user_can_filter_tasks_by_status()
    {
        $this->actingAs($this->user);
        
        // Создаем завершенные и незавершенные задачи
        Task::factory()->count(2)->create([
            'user_id' => $this->user->id,
            'completed' => true
        ]);
        
        Task::factory()->count(3)->create([
            'user_id' => $this->user->id,
            'completed' => false
        ]);

        // Проверяем фильтр "все задачи"
        $response = $this->get(route('tasks.index', ['filter' => 'all']));
        $response->assertStatus(200);
        $this->assertCount(5, $response->viewData('tasks'));

        // Проверяем фильтр "завершенные"
        $response = $this->get(route('tasks.index', ['filter' => 'completed']));
        $response->assertStatus(200);
        $this->assertCount(2, $response->viewData('tasks'));

        // Проверяем фильтр "активные"
        $response = $this->get(route('tasks.index', ['filter' => 'pending']));
        $response->assertStatus(200);
        $this->assertCount(3, $response->viewData('tasks'));
    }

    /** @test */
    public function user_can_search_tasks_by_title()
    {
        $this->actingAs($this->user);
        
        // Создаем задачи
        Task::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Важная задача'
        ]);
        
        Task::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Обычная задача'
        ]);
        
        // Поиск по части названия
        $response = $this->get(route('tasks.index', ['search' => 'Важная']));
        $response->assertStatus(200);
        $this->assertCount(1, $response->viewData('tasks'));
        $this->assertEquals('Важная задача', $response->viewData('tasks')->first()->title);
    }

    /** @test */
    public function user_can_search_tasks_by_description()
    {
        $this->actingAs($this->user);
        
        // Создаем задачи
        Task::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Задача 1',
            'description' => 'Нужно сделать срочно'
        ]);
        
        Task::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Задача 2',
            'description' => 'Можно сделать позже'
        ]);
        
        // Поиск по описанию
        $response = $this->get(route('tasks.index', ['search' => 'срочно']));
        $response->assertStatus(200);
        $this->assertCount(1, $response->viewData('tasks'));
        $this->assertEquals('Нужно сделать срочно', $response->viewData('tasks')->first()->description);
    }
}