<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\RoomPlayer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomPlayerFactory extends Factory
{
    protected $model = RoomPlayer::class;

    public function definition(): array
    {
        return [
            'room_id' => Room::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
            'joined_at' => fake()->dateTimeBetween('-1 day'),
        ];
    }
}