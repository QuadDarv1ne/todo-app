<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tagNames = [
            'Работа', 'Личное', 'Срочно', 'Важно', 'Проект',
            'Покупки', 'Здоровье', 'Учеба', 'Дом', 'Идеи'
        ];
        
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->unique()->randomElement($tagNames),
            'color' => $this->faker->randomElement(Tag::COLORS),
        ];
    }
}
