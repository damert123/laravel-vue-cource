<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory(10)->create();


//       $categories = [
//           ['title' => 'Технологии'],
//           ['title' => 'Здоровье'],
//           ['title' => 'Путешествия'],
//           ['title' => 'Обучение'],
//           ['title' => 'Еда'],
//       ];
//
//       foreach ($categories as $category) {
//           Category::create($category);
//       }
    }
}
