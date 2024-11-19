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
        Category::create(['category_name' => 'ゲーム', 'category_image' => null]);
        Category::create(['category_name' => 'マンガ', 'category_image' => null]);
        Category::create(['category_name' => 'ジャニーズ', 'category_image' => null]);
        Category::create(['category_name' => 'ディズニー', 'category_image' => null]);
        Category::create(['category_name' => '洋服', 'category_image' => null]);
        Category::create(['category_name' => '日用品', 'category_image' => null]);
        Category::create(['category_name' => 'その他', 'category_image' => null]);
    }
}
