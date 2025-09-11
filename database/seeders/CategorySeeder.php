<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Lokal Sumba' => '#6A5ACD',
            'Budaya & Tradisi' => '#008000',
            'Pendidikan & Sosial' => '#20B2AA',
            'Politik & Pemerintahan' => '#1E3A8A',
            'Ekonomi & Bisnis' => '#32CD32',
            'Olahraga & Prestasi' => '#FFA500',
            'Kecelakaan & Kejadian' => '#B22222',
            'Hiburan & Lifestyle' => '#FF69B4',
            'Teknologi & Inovasi' => '#8A2BE2',
            'Nasional' => '#FF0000',
        ];

        foreach ($categories as $name => $color) {
            Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'color' => $color,
                ]
            );
        }
    }
}
