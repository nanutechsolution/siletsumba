<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            ['name' => 'Politik', 'slug' => 'politik'],
            ['name' => 'Ekonomi', 'slug' => 'ekonomi'],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan'],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan'],
            ['name' => 'Budaya', 'slug' => 'budaya'],
            ['name' => 'Olahraga', 'slug' => 'olahraga'],
            ['name' => 'Pariwisata', 'slug' => 'pariwisata'],
            ['name' => 'Infrastruktur', 'slug' => 'infrastruktur'],
            ['name' => 'Lingkungan', 'slug' => 'lingkungan'],
            ['name' => 'Kriminal', 'slug' => 'kriminal'],
        ];

        foreach ($tags as $tag) {
            Tag::updateOrCreate(
                ['slug' => $tag['slug']], // unik berdasarkan slug
                ['name' => $tag['name']]
            );
        }
    }
}