<?php

namespace Database\Seeders;

use App\Models\ThemeSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThemeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ThemeSetting::create([
            'primary_color' => '#4299e1', // blue-500
            'secondary_color' => '#f56565', // red-500
            'menu_background' => '#ffffff', // white
        ]);
    }
}
