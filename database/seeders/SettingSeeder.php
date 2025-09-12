<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menonaktifkan pemeriksaan foreign key untuk truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Setting::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $settings = [
            [
                'key' => 'site_name',
                'value' => 'Silet Sumba',
            ],
            [
                'key' => 'site_description',
                'value' => 'Berita dan informasi terkini dari Sumba. Tajam, lugas, dan terpercaya.',
            ],
            [
                'key' => 'site_logo_url',
                'value' => 'images/logo-siletsumba.png', // Contoh path logo
            ],
            [
                'key' => 'social_facebook_url',
                'value' => 'https://www.facebook.com/siletsumba',
            ],
            [
                'key' => 'social_twitter_url',
                'value' => 'https://www.twitter.com/siletsumba',
            ],
            [
                'key' => 'social_instagram_url',
                'value' => 'https://www.instagram.com/siletsumba',
            ],
            [
                'key' => 'contact_email',
                'value' => 'redaksi@siletsumba.com',
            ],
            [
                'key' => 'contact_phone',
                'value' => '+6281234567890',
            ],
            [
                'key' => 'contact_address',
                'value' => 'Jalan Siliwangi No. 12, Kelurahan Temanggung, Kecamatan Kuantan, Sumba Timur',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
