<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Game;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startedAt = fake()->dateTimeBetween('-1 day');

        return [
            'room_id' => static function () {
                return Room::factory()->create()->id;
            },
            'category_id' => static function () {
                return Category::inRandomOrder()->first()->id;
            },
            'started_at' => $startedAt,
            'finished_at' => fake()->optional(0.7)->dateTimeBetween($startedAt),
            'status' => fake()->randomElement(['active', 'completed', 'cancelled']),
        ];
    }
}