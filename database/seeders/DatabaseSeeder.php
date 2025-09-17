<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Prompt;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Yakobus Tena',
            'email' => 'silet@sumba.com',
            'role' => 'admin'
        ]);
        $this->call([
            CategorySeeder::class,
            ArticleSeeder::class,
            PromptSeeder::class,
            TagSeeder::class,
            ArticleTagSeeder::class,
            SettingSeeder::class,
            PagesSeeder::class,
        ]);
    }
}