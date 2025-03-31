<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Game;
use App\Models\PlayerAnswer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlayerAnswer>
 */
class PlayerAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $question = Question::factory()->create();
        $answer = Answer::factory()->create();

        return [
            'game_id' => static function () {
                return Game::factory()->create()->id;
            },
            'user_id' => static function () {
                return User::factory()->create()->id;
            },
            'question_id' => $question->id,
            'answer_id' => fake()->optional(0.9)->numberBetween(1, $answer->id),
            'is_correct' => fake()->boolean(60),
            'answered_at' => fake()->dateTimeBetween('-1 month'),
        ];
    }
}