<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['category_name' => 'アニメ', 'category_image' => 'images/categories/anime.jpg']);
        Category::create(['category_name' => 'ゲーム', 'category_image' => 'images/categories/game.jpg']);
        Category::create(['category_name' => 'マンガ', 'category_image' => 'images/categories/manga.jpg']);
        Category::create(['category_name' => '洋服', 'category_image' => 'images/categories/youfuku.jpg']);
        Category::create(['category_name' => '日用品', 'category_image' => 'images/categories/nichiyouhin.jpg']);
        Category::create(['category_name' => 'その他', 'category_image' => 'images/categories/sonota.jpg']);
    }
}
