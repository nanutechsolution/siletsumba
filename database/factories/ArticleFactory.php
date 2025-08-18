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
        return [
            'title' => $this->faker->sentence(mt_rand(3, 8)),
            'slug' => $this->faker->unique()->slug(),
            'content' => $this->faker->paragraphs(mt_rand(5, 10), true),
            'category_id' => Category::factory(),
        ];
    }
}
