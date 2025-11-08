<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    protected static ?string $password;
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'bio' => $this->faker->optional(0.7)->paragraphs(2, true), // 70% шанс заполнить биографию
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            // 'password' => bcrypt('password'), // По умолчанию для тестов
            'remember_token' => Str::random(10),
            'role' => $this->faker->randomElement(['user', 'manager', 'admin']),
            'task_limit' => $this->faker->randomElement([50, 100, 200, 500]),
            'avatar_path' => $this->faker->optional(0.5)->imageUrl(150, 150, 'people', true),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'task_limit' => 1000,
            'bio' => 'Администратор системы управления задачами. Отвечает за поддержку и развитие платформы.',
        ]);
    }

    public function manager(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'manager',
            'task_limit' => 500,
            'bio' => 'Менеджер проектов. Координирует выполнение задач и отслеживает прогресс команды.',
        ]);
    }

    public function withBio(): static
    {
        return $this->state(fn (array $attributes) => [
            'bio' => $this->faker->paragraphs(rand(1, 3), true),
        ]);
    }

    public function withShortBio(): static
    {
        return $this->state(fn (array $attributes) => [
            'bio' => $this->faker->sentence(10),
        ]);
    }

    public function withoutBio(): static
    {
        return $this->state(fn (array $attributes) => [
            'bio' => null,
        ]);
    }

    public function withTasks(int $count = 10): static
    {
        return $this->afterCreating(function (User $user) use ($count) {
            $user->tasks()->saveMany(
                \App\Models\Task::factory()
                    ->count($count)
                    ->state(function (array $attributes) use ($user) {
                        return [
                            'completed' => $this->faker->boolean(70), // 70% завершенных
                        ];
                    })
                    ->make()
            );
        });
    }

    public function withHighCompletionRate(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->tasks()->saveMany(
                \App\Models\Task::factory()
                    ->count(20)
                    ->state(['completed' => true])
                    ->make()
            );
        });
    }

    public function withLowCompletionRate(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->tasks()->saveMany(
                \App\Models\Task::factory()
                    ->count(20)
                    ->state(['completed' => false])
                    ->make()
            );
        });
    }

    public function withAvatar(): static
    {
        return $this->state(fn (array $attributes) => [
            'avatar_path' => 'avatars/' . Str::random(10) . '.jpg',
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
