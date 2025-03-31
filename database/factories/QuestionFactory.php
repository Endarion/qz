<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => static function () {
                return Category::inRandomOrder()->first()->id;
            },
            'text' => fake()->sentence() . '?',
            'type' => fake()->randomElement(['single', 'multiple']),
            'image' => fake()->randomElement([fake()->imageUrl, null]),
            'difficulty' => fake()->randomElement(['easy', 'medium', 'hard']),
        ];
    }
}