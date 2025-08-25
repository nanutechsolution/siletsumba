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
            'Nasional' => '#FF0000',        // merah
            'Internasional' => '#1E90FF',   // biru
            'Ekonomi' => '#32CD32',         // hijau
            'Olahraga' => '#FFA500',        // oranye
            'Teknologi' => '#8A2BE2',       // ungu
            'Hiburan' => '#FF69B4',         // pink
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
