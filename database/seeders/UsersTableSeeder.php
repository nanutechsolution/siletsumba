<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@portal.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'slug' => Str::slug('Admin'),
                'bio' => 'Administrator portal berita.',
                'is_active' => 1
            ],
            [
                'name' => 'Editor',
                'email' => 'editor@portal.com',
                'password' => Hash::make('password123'),
                'role' => 'editor',
                'slug' => Str::slug('Editor'),
                'bio' => 'Editor portal berita.',
                'is_active' => 1
            ],
            [
                'name' => 'Writer',
                'email' => 'writer@portal.com',
                'password' => Hash::make('password123'),
                'role' => 'writer',
                'slug' => Str::slug('Writer'),
                'bio' => 'Penulis portal berita.',
                'is_active' => 1
            ],
        ];

        DB::table('users')->insert($users);
    }
}