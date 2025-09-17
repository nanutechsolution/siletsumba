<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title'   => 'Tentang Kami',
                'slug'    => 'tentang-kami',
                'content' => '<p>Portal berita ini adalah media online resmi yang menyajikan informasi terkini, terpercaya, dan mendidik masyarakat. Kami berkomitmen pada prinsip jurnalistik yang berimbang, akurat, dan independen.</p>',
                'status'  => 'published',
            ],
            [
                'title'   => 'Pedoman Media Siber',
                'slug'    => 'pedoman-media-siber',
                'content' => '<p>Pedoman Media Siber mengacu pada peraturan Dewan Pers mengenai standar etika dan tata cara pengelolaan media online, termasuk penyajian berita yang benar, hak jawab, serta perlindungan privasi.</p>',
                'status'  => 'published',
            ],
            [
                'title'   => 'Disclaimer',
                'slug'    => 'disclaimer',
                'content' => '<p>Semua artikel yang diterbitkan di portal berita ini disajikan apa adanya. Redaksi tidak bertanggung jawab atas kerugian yang mungkin timbul dari penggunaan informasi di situs ini.</p>',
                'status'  => 'published',
            ],
            [
                'title'   => 'Kebijakan Privasi',
                'slug'    => 'kebijakan-privasi',
                'content' => '<p>Kami menghargai privasi pengguna. Informasi pribadi yang dikumpulkan hanya digunakan untuk kepentingan internal dan tidak akan dibagikan tanpa izin.</p>',
                'status'  => 'published',
            ],
            [
                'title'   => 'Kontak Kami',
                'slug'    => 'kontak-kami',
                'content' => '<p>Untuk kritik, saran, atau pengajuan berita, silakan hubungi redaksi melalui email: redaksi@portalberita.com atau WhatsApp: 0812-3456-7890.</p>',
                'status'  => 'published',
            ],
            [
                'title'   => 'Kode Etik Jurnalistik',
                'slug'    => 'kode-etik-jurnalistik',
                'content' => '<p>Kami berpedoman pada Kode Etik Jurnalistik Dewan Pers, menjunjung tinggi kebenaran, tidak beritikad buruk, dan selalu menghormati narasumber serta masyarakat.</p>',
                'status'  => 'published',
            ],
            [
                'title'   => 'Redaksi',
                'slug'    => 'redaksi',
                'content' => '
                    <h2 class="font-bold text-lg mb-2">Identitas Media</h2>
                    <p><strong>Silet Sumba</strong><br>
                    Alamat: Jl. Contoh No. 123, Waingapu, Sumba Timur<br>
                    Telp: (0382) 123456 | Email: redaksi@siletsumba.com</p>

                    <h2 class="font-bold text-lg mt-4 mb-2">Struktur Redaksi</h2>
                    <ul class="list-disc ml-6">
                        <li>Pemimpin Umum: Urbanus Gani</li>
                        <li>Pemimpin Redaksi: Cristian Bili Dangga</li>
                        <li>Redaktur Pelaksana: Maria Sumba</li>
                        <li>Reporter: Tim Jurnalis Silet Sumba</li>
                        <li>IT & Web: Ranus</li>
                        <li>Marketing & Iklan: Tim Marketing</li>
                    </ul>

                    <h2 class="font-bold text-lg mt-4 mb-2">Disclaimer</h2>
                    <p>Silet Sumba berkomitmen mematuhi UU Pers No. 40 Tahun 1999 dan Kode Etik Jurnalistik.
                    Segala bentuk opini yang dimuat merupakan tanggung jawab penulis. Hak jawab dapat diajukan
                    melalui email redaksi.</p>
                ',
                'status'  => 'published',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}