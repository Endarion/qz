<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Room;
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
        // User::factory(10)->create();

        User::factory(10)->create();

        $this->call([
            CategoriesTableSeeder::class,
        ]);

        Room::factory(5)->create();
        Question::factory(20)->create()->each(static function (Question $question) {
            Answer::factory(4)->create(['question_id' => $question->id]);
        });

    }
}