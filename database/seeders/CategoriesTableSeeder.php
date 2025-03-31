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
            ['name' => 'Программирование', 'slug' => 'programming', 'icon' => 'fa-code'],
            ['name' => 'История', 'slug' => 'history', 'icon' => 'fa-landmark'],
            ['name' => 'Наука', 'slug' => 'science', 'icon' => 'fa-flask'],
            ['name' => 'Кино', 'slug' => 'movies', 'icon' => 'fa-film'],
            ['name' => 'Игры', 'slug' => 'games', 'icon' => 'fa-gamepad'],
            ['name' => 'Музыка', 'slug' => 'music', 'icon' => 'fa-music'],
            ['name' => 'Спорт', 'slug' => 'sports', 'icon' => 'fa-football'],
            ['name' => 'География', 'slug' => 'geography', 'icon' => 'fa-globe'],
            ['name' => 'Искусство', 'slug' => 'art', 'icon' => 'fa-palette'],
            ['name' => 'Еда', 'slug' => 'food', 'icon' => 'fa-utensils'],
            ['name' => 'Технологии', 'slug' => 'tech', 'icon' => 'fa-microchip'],
            ['name' => 'Животные', 'slug' => 'animals', 'icon' => 'fa-paw'],
            ['name' => 'Литература', 'slug' => 'books', 'icon' => 'fa-book-open'],
            ['name' => 'Автомобили', 'slug' => 'cars', 'icon' => 'fa-car'],
            ['name' => 'Медицина', 'slug' => 'medicine', 'icon' => 'fa-heart-pulse'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name'], 'slug' => $category['slug'], 'icon' => $category['icon']]
            );
        }
    }
}