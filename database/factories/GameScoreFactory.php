<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\GameScore;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GameScore>
 */
class GameScoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'game_id' => static function () {
                return Game::factory()->create()->id;
            },
            'user_id' => static function () {
                return User::factory()->create()->id;
            },
            'score' => fake()->numberBetween(0, 1000),
            'rank' => fake()->numberBetween(1, 10),
        ];
    }
}