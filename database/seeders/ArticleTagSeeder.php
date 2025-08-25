<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Tag;

class ArticleTagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = Tag::all();

        // Pastikan ada tag dulu
        if ($tags->count() == 0) {
            $this->command->warn('No tags found, run TagSeeder first!');
            return;
        }

        Article::all()->each(function ($article) use ($tags) {
            // pilih 1–3 tag random
            $randomTags = $tags->random(rand(1, 3))->pluck('id');
            $article->tags()->sync($randomTags);
        });
    }
}
