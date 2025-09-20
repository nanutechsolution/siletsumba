<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // 1️⃣ Buat permission (key aman untuk backend, label untuk UI)
        $permissions = [
            'buat_artikel' => 'Buat Artikel',
            'edit_artikel_sendiri' => 'Edit Artikel Sendiri',
            'edit_semua_artikel' => 'Edit Semua Artikel',
            'setujui_artikel' => 'Setujui Artikel',
            'hapus_artikel' => 'Hapus Artikel',
            'kelola_pengguna' => 'Kelola Pengguna',
            'kelola_kategori' => 'Kelola Kategori',
            'kelola_komentar' => 'Kelola Komentar',
            'hapus_komentar' => 'Hapus Komentar',
            'kelola_pengaturan' => 'Kelola Pengaturan',
            'kelola_tag' => 'Kelola Tag',
            'kelola_iklan' => 'Kelola Iklan',
            'kelola_halaman' => 'Kelola Halaman',
            'kelola_prompt' => 'Kelola Prompt',
            'buat_konten' => 'Buat Konten',
            'baca_artikel' => 'Baca Artikel'
        ];

        foreach ($permissions as $key => $label) {
            Permission::firstOrCreate(['name' => $key, 'guard_name' => 'web']);
        }

        // 2️⃣ Buat role
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $writer = Role::firstOrCreate(['name' => 'writer']);
        $guest = Role::firstOrCreate(['name' => 'tamu']);
        // 3️⃣ Assign permission ke role
        $admin->givePermissionTo(Permission::all());

        $editor->givePermissionTo([
            'edit_semua_artikel',
            'setujui_artikel',
            'kelola_komentar',
            'hapus_komentar',
            'kelola_prompt',
            'baca_artikel'
        ]);

        $writer->givePermissionTo([
            'buat_artikel',
            'edit_artikel_sendiri',
            'baca_artikel'
        ]);

        $guest->givePermissionTo([
            'baca_artikel'
        ]);

        // 4️⃣ Buat user default admin
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@portal.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password123')
            ]
        );
        $adminUser->assignRole('admin');
    }
}
