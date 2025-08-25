<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Infrastruktur',
            'Ekonomi',
            'Jawa Timur',
            'Pembangunan',
            'Olahraga',
            'Politik',
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(
                ['slug' => \Str::slug($tag)], // cek dulu berdasarkan slug
                ['name' => $tag]
            );
        }
    }
}
