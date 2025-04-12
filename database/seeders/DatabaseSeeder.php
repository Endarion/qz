<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Game;
use App\Models\GameQuestion;
use App\Models\GameScore;
use App\Models\PlayerAnswer;
use App\Models\Question;
use App\Models\Room;
use App\Models\RoomPlayer;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create(['name' => 'Endarion', 'password' => 12345678, 'email' => 'desandel@yandex.ru']);

        $this->call([
            CategoriesTableSeeder::class,
        ]);

        Room::factory(5)->create()->each(static function (Room $room) {
            RoomPlayer::factory(3)->create(['room_id' => $room->id]);
        });

        Question::factory(20)->create()->each(static function (Question $question) {
            Answer::factory(4)->create(['question_id' => $question->id]);
        });

        Game::factory(3)->create()->each(static function (Game $game) {
            GameQuestion::factory(5)->create(['game_id' => $game->id]);
            PlayerAnswer::factory(10)->create(['game_id' => $game->id]);
            GameScore::factory(3)->create(['game_id' => $game->id]);
        });
    }
}
