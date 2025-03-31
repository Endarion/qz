<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\GameQuestion;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GameQuestion>
 */
class GameQuestionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'game_id' => static function () {
                return Game::factory()->create()->id;
            },
            'question_id' => static function () {
                return Question::factory()->create()->id;
            },
            'order' => fake()->numberBetween(1, 10),
        ];
    }
}