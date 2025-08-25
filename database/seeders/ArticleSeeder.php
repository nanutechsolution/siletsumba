<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori sudah ada
        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }

        // Buat 50 artikel random
        Article::factory()->count(50)->create();
    }
}
