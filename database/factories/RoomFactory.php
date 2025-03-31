<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'code' => fake()->unique()->randomNumber(),
            'host_id' => User::factory(),
            'is_public' => fake()->boolean(),
            'password' => static fn(array $attributes) => $attributes['is_public'] ? null : 'secret',
            'max_players' => fake()->numberBetween(2, 4),
            'status' => fake()->randomElement(['waiting', 'playing', 'finished']),
            'question_count' => fake()->numberBetween(5, 30),
        ];
    }

    public function withTwoPlayers(): Factory|RoomFactory
    {
        return $this->state(['max_players' => 2]);
    }

    public function withFourPlayers(): Factory|RoomFactory
    {
        return $this->state(['max_players' => 4]);
    }
}