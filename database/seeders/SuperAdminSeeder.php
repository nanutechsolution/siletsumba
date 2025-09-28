<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Buat role super-admin jika belum ada
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);

        // Beri semua permission
        $superAdmin->givePermissionTo(Permission::all());

        // Buat user super-admin jika belum ada
        $superAdminUser = User::firstOrCreate(
            ['email' => 'superadmin@portal.com'],
            [
                'name' => 'Super Administrator',
                'password' => bcrypt('superpassword123') // ganti sesuai kebutuhan
            ]
        );

        // Assign role super-admin
        $superAdminUser->assignRole('super-admin');
    }
}
