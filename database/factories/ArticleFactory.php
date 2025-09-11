<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(mt_rand(4, 8));

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(5), // biar unik
            'content' => $this->faker->paragraphs(mt_rand(5, 10), true),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'views' => $this->faker->numberBetween(10, 5000),
            'author' => $this->faker->name(),
        ];
    }
}
