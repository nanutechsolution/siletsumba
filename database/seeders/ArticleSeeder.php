<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create([
            'name' => 'Redaksi Silet Sumba',
            'email' => 'redaksi@siletsumba.com',
            'password' => bcrypt('password'),
        ]);

        // Ambil kategori berdasarkan slug
        $categories = Category::pluck('id', 'slug');

        $articles = [
            [
                'title' => 'Kecelakaan Maut di Jalan Trans Sumba, Dua Korban Meninggal',
                'slug' => Str::slug('Kecelakaan Maut di Jalan Trans Sumba, Dua Korban Meninggal'),
                'category' => 'kecelakaan-kejadian',
                'content' => '
                    <h2>Kronologi Kejadian</h2>
                    <p><strong>Kecelakaan tragis</strong> terjadi di Jalan Trans Sumba, Selasa sore (10/09/2025). 
                    Dua remaja pengendara motor tewas di tempat setelah bertabrakan dengan truk bermuatan bahan bangunan.</p>
                ',
                'is_breaking' => true,
            ],
            [
                'title' => 'Festival Tenun Ikat Sumba 2025 Resmi Dibuka di Waingapu',
                'slug' => Str::slug('Festival Tenun Ikat Sumba 2025 Resmi Dibuka di Waingapu'),
                'category' => 'budaya-tradisi',
                'content' => '
                    <h2>Pesona Tenun Ikat</h2>
                    <p>Ratusan penenun lokal menampilkan karya terbaik mereka dalam <em>Festival Tenun Ikat Sumba 2025</em>. 
                    Acara dibuka dengan tarian tradisional dan pameran produk UMKM.</p>
                ',
                'is_breaking' => false,
            ],
            [
                'title' => 'Harga Jagung di Pasar Waikabubak Melonjak Tajam',
                'slug' => Str::slug('Harga Jagung di Pasar Waikabubak Melonjak Tajam'),
                'category' => 'ekonomi-bisnis',
                'content' => '
                    <p>Harga jagung di Pasar Waikabubak naik hingga 40% dalam dua pekan terakhir. 
                    Para petani menyambut baik kenaikan ini, meski dikhawatirkan membebani konsumen.</p>
                ',
                'is_breaking' => false,
            ],
            [
                'title' => 'Banjir Bandang Terjang Desa di Sumba Timur',
                'slug' => Str::slug('Banjir Bandang Terjang Desa di Sumba Timur'),
                'category' => 'lokal-sumba',
                'content' => '
                    <p>Banjir bandang melanda Desa Prailiu, Sumba Timur, akibat hujan deras semalaman. 
                    Puluhan rumah terendam dan ratusan warga mengungsi ke balai desa.</p>
                ',
                'is_breaking' => true,
            ],
            [
                'title' => 'Pariwisata Sumba Masuk 10 Besar Destinasi Favorit Indonesia',
                'slug' => Str::slug('Pariwisata Sumba Masuk 10 Besar Destinasi Favorit Indonesia'),
                'category' => 'lokal-sumba',
                'content' => '
                    <p>Pantai Nihiwatu dan Bukit Wairinding membuat Sumba semakin dikenal wisatawan mancanegara. 
                    Data terbaru Kemenparekraf menunjukkan kunjungan wisatawan meningkat 35% tahun ini.</p>
                ',
                'is_breaking' => false,
            ],
            [
                'title' => 'Listrik Padam 8 Jam di Anakalang, Aktivitas Warga Terganggu',
                'slug' => Str::slug('Listrik Padam 8 Jam di Anakalang, Aktivitas Warga Terganggu'),
                'category' => 'lokal-sumba',
                'content' => '
                    <p>PLN Sumba Barat menjelaskan pemadaman terjadi karena perbaikan jaringan. 
                    Warga mengeluh aktivitas terganggu, terutama pelaku usaha kecil.</p>
                ',
                'is_breaking' => false,
            ],
            [
                'title' => 'Petani Sumba Barat Daya Panen Padi Melimpah',
                'slug' => Str::slug('Petani Sumba Barat Daya Panen Padi Melimpah'),
                'category' => 'ekonomi-bisnis',
                'content' => '
                    <p>Musim panen kali ini membawa senyum bagi petani di Kodi. 
                    Produksi padi meningkat 20% berkat curah hujan yang cukup dan bantuan pupuk subsidi.</p>
                ',
                'is_breaking' => false,
            ],
            [
                'title' => 'Sekolah Adat Sumba Ajarkan Generasi Muda Tentang Marapu',
                'slug' => Str::slug('Sekolah Adat Sumba Ajarkan Generasi Muda Tentang Marapu'),
                'category' => 'budaya-tradisi',
                'content' => '
                    <p>Sebuah sekolah adat di Sumba Tengah mengajarkan anak-anak tentang kepercayaan Marapu, 
                    seni tenun, dan tarian tradisional. Program ini mendapat dukungan penuh dari tokoh adat.</p>
                ',
                'is_breaking' => false,
            ],
            [
                'title' => 'Turnamen Sepak Bola Antar Desa di Sumba Barat Meriah',
                'slug' => Str::slug('Turnamen Sepak Bola Antar Desa di Sumba Barat Meriah'),
                'category' => 'olahraga-prestasi',
                'content' => '
                    <p>Lapangan Mandaelu dipadati ribuan penonton yang antusias mendukung tim desa masing-masing. 
                    Turnamen ini digelar untuk mempererat persaudaraan antarwarga.</p>
                ',
                'is_breaking' => false,
            ],
            [
                'title' => 'Bandara Tambolaka Siap Sambut Penerbangan Malam',
                'slug' => Str::slug('Bandara Tambolaka Siap Sambut Penerbangan Malam'),
                'category' => 'lokal-sumba',
                'content' => '
                    <p>Pihak otoritas bandara memastikan fasilitas penerangan dan navigasi sudah memenuhi standar. 
                    Hal ini akan memperlancar arus kunjungan wisatawan ke Sumba.</p>
                ',
                'is_breaking' => false,
            ],
        ];

        foreach ($articles as $data) {
            Article::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'content' => $data['content'],
                'category_id' =>  $categories[$data['category']] ?? null,
                'user_id' => $user->id,
                'is_breaking' => $data['is_breaking'],
            ]);
        }
    }
}
