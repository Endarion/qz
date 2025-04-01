<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Программирование', 'slug' => 'programming', 'icon' => 'fas-code'],
            ['name' => 'История', 'slug' => 'history', 'icon' => 'fas-landmark'],
            ['name' => 'Наука', 'slug' => 'science', 'icon' => 'fas-flask'],
            ['name' => 'Кино', 'slug' => 'movies', 'icon' => 'fas-film'],
            ['name' => 'Игры', 'slug' => 'games', 'icon' => 'fas-gamepad'],
            ['name' => 'Музыка', 'slug' => 'music', 'icon' => 'fas-music'],
            ['name' => 'Спорт', 'slug' => 'sports', 'icon' => 'fas-football'],
            ['name' => 'География', 'slug' => 'geography', 'icon' => 'fas-globe'],
            ['name' => 'Искусство', 'slug' => 'art', 'icon' => 'fas-palette'],
            ['name' => 'Еда', 'slug' => 'food', 'icon' => 'fas-utensils'],
            ['name' => 'Технологии', 'slug' => 'tech', 'icon' => 'fas-microchip'],
            ['name' => 'Животные', 'slug' => 'animals', 'icon' => 'fas-paw'],
            ['name' => 'Литература', 'slug' => 'books', 'icon' => 'fas-book-open'],
            ['name' => 'Автомобили', 'slug' => 'cars', 'icon' => 'fas-car'],
            ['name' => 'Медицина', 'slug' => 'medicine', 'icon' => 'fas-heart-pulse'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name'], 'slug' => $category['slug'], 'icon' => $category['icon']]
            );
        }
    }
}
