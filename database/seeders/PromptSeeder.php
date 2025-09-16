<?php

namespace Database\Seeders;

use App\Models\Prompt;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PromptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menonaktifkan foreign key checks untuk truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Prompt::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Base prompt untuk peran editor
        $basePrompt = "Anda adalah seorang editor senior dengan pengalaman lebih dari 10 tahun di media online lokal Sumba. Buat artikel berita untuk website \"Silet Sumba\" berdasarkan data mentah yang diberikan. Output harus HANYA dalam format HTML murni, dimulai dengan tag <p>. JANGAN sertakan judul, kategori, atau informasi lain di luar isi artikel.";

        // 1. Tombol Generate Berita Lokal (Faktual & Umum)
        Prompt::create([
            'name' => 'berita_lokal',
            'button_text' => 'Generate Berita Lokal',
            'description' => 'Membuat artikel berita umum yang lugas, profesional, dan faktual. Ideal untuk semua laporan berita harian.',
            'prompt_template' => $basePrompt . " Gaya penulisan: lugas, profesional, dan faktual. Masukkan data: Judul: {title}, Kategori: {category}, Lokasi: {location}, Fakta/Kronologi: {facts}, Kutipan/Narasumber: {quotes}. Sertakan konteks sosial atau dampak bagi masyarakat jika relevan.",
            'color' => '#800080'
        ]);

        // 2. Tombol Silet Sumba (Investigasi & Tajam)
        Prompt::create([
            'name' => 'silet_sumba',
            'button_text' => 'Silet Sumba',
            'description' => 'Membuat artikel dengan gaya ringkas, tajam, dan langsung ke inti masalah. Cocok untuk berita investigasi atau isu-isu kontroversial.',
            'prompt_template' => $basePrompt . " Gaya penulisan: ringkas, tajam, dan lugas. Fokus pada inti masalah dari data: Judul: {title}, Kategori: {category}, Lokasi: {location}, Fakta: {facts}, Kutipan: {quotes}. Gunakan <strong>, <em>, atau <u> untuk menekankan poin penting.",
            'color' => '#0000FF'
        ]);

        // 3. Tombol Liputan Budaya (Mendalam & Informatif)
        Prompt::create([
            'name' => 'liputan_budaya',
            'button_text' => 'Liputan Budaya',
            'description' => 'Menulis laporan mendalam tentang tradisi, seni, atau event budaya lokal. Menyoroti keunikan dan makna di baliknya.',
            'prompt_template' => $basePrompt . " Gaya penulisan: informatif dan menarik. Buat artikel yang mendalam tentang budaya Sumba dari data: Judul: {title}, Kategori: {category}, Lokasi: {location}, Fakta: {facts}, Kutipan: {quotes}. Soroti keunikan tradisi, makna di baliknya, dan perannya bagi masyarakat modern. Gunakan subjudul (<h3>) untuk membagi topik.",
            'color' => '#228B22'
        ]);

        // 4. Tombol Tulis Opini (Kolom Opini & Perspektif)
        Prompt::create([
            'name' => 'tulis_opini',
            'button_text' => 'Tulis Opini',
            'description' => 'Membuat artikel opini dengan sudut pandang yang kuat dan mencerminkan perspektif lokal. Ideal untuk kolom yang memancing diskusi.',
            'prompt_template' => $basePrompt . " Gaya penulisan: opini yang tajam dan terstruktur. Berikan pendapat berdasarkan informasi: Judul: {title}, Kategori: {category}, Lokasi: {location}, Fakta: {facts}, Kutipan: {quotes}. Gunakan <strong>, <em>, atau <u> untuk highlight pendapat penting.",
            'color' => '#FF0000'
        ]);

        // 5. Tombol Promosi Lokal (Copywriting AIDA)
        Prompt::create([
            'name' => 'promosi_lokal',
            'button_text' => 'Promosi Lokal (AIDA)',
            'description' => 'Membuat konten promosi yang persuasif untuk event, produk UMKM, atau tempat wisata menggunakan metode AIDA (Attention, Interest, Desire, Action).',
            'prompt_template' => $basePrompt . " Gaya penulisan: persuasif dan menarik. Buat konten promosi dengan metode AIDA (Attention, Interest, Desire, Action) menggunakan informasi: Judul/Produk: {title}, Kategori: {category}, Lokasi: {location}, Fakta/Manfaat: {facts}. Tambahkan kutipan dari pelanggan/narasumber: {quotes}. Tulis dengan bahasa yang persuasif dan ajakan bertindak (call-to-action) yang jelas.",
            'color' => '#4B0082'
        ]);

        // 6. Tombol Ringkasan Kilat (Efisiensi Konten)
        Prompt::create([
            'name' => 'ringkasan_kilat',
            'button_text' => 'Ringkasan Kilat',
            'description' => 'Merangkum artikel berita panjang menjadi poin-poin utama dalam 2-3 paragraf. Ideal untuk ringkasan cepat.',
            'prompt_template' => $basePrompt . " Gaya penulisan: ringkas dan padat. Fokus pada inti berita, termasuk 5W+1H (Apa, Siapa, Kapan, Di mana, Mengapa, Bagaimana). Gunakan informasi: Judul: {title}, Kategori: {category}, Lokasi: {location}, Fakta/Kronologi: {facts}.",
            'color' => '#FFA500'
        ]);

        // 7. Tombol Headline Pilihan (Optimalisasi SEO)
        Prompt::create([
            'name' => 'headline_pilihan',
            'button_text' => 'Headline Pilihan',
            'description' => 'Menghasilkan 5 alternatif judul yang menarik dan dioptimalkan untuk SEO, membantu artikel mendapatkan lebih banyak klik.',
            'prompt_template' => "Berdasarkan Judul: {title} dan Fakta: {facts}, buat 5 alternatif judul berita yang menarik dan profesional. Berikan variasi judul yang sensasional, lugas, dan berfokus pada SEO. Output HANYA sebagai daftar HTML dengan tag <h3> untuk setiap judul.",
            'color' => '#FFD700'
        ]);

        // 8. Tombol Laporan Khusus (Naratif & Mendalam)
        Prompt::create([
            'name' => 'laporan_khusus',
            'button_text' => 'Laporan Khusus',
            'description' => 'Membuat laporan yang lebih panjang dan mendalam untuk artikel fitur. Melibatkan narasi yang kuat dan detail yang lebih dalam.',
            'prompt_template' => $basePrompt . " Gaya penulisan: naratif dan mendalam. Kembangkan artikel dengan minimal 5 paragraf. Sisipkan subjudul (<h3>) yang relevan. Gunakan informasi: Judul: {title}, Kategori: {category}, Lokasi: {location}, Fakta: {facts}, Kutipan: {quotes}. Sertakan analisis dampak sosial atau ekonomi dari peristiwa tersebut bagi masyarakat Sumba.",
            'color' => '#8B4513'
        ]);

        // 9. Tombol Profil Tokoh (Humanis & Inspiratif)
        Prompt::create([
            'name' => 'profil_tokoh',
            'button_text' => 'Profil Tokoh',
            'description' => 'Membuat profil naratif tentang tokoh masyarakat, seniman, atau pahlawan lokal. Fokus pada sisi personal dan inspiratif.',
            'prompt_template' => $basePrompt . " Gaya penulisan: personal dan menyentuh. Buat profil naratif tentang tokoh inspiratif dari data: Judul: {title}, Kategori: {category}, Lokasi: {location}, Fakta: {facts}, Kutipan: {quotes}. Soroti perjalanan, tantangan, dan kontribusi tokoh tersebut bagi Sumba.",
            'color' => '#FFC0CB'
        ]);

        // 10. Tombol Wawancara AI (Interaktif & Terstruktur)
        Prompt::create([
            'name' => 'wawancara_ai',
            'button_text' => 'Wawancara AI',
            'description' => 'Menghasilkan draf wawancara dengan pertanyaan dan jawaban yang dirangkai secara logis dari fakta dan kutipan yang diberikan.',
            'prompt_template' => "Bertindaklah sebagai jurnalis Sumba yang sedang mewawancarai narasumber. Berdasarkan Kutipan: {quotes} dan Fakta: {facts}, buatlah skrip wawancara dengan format Tanya Jawab. Rangkai pertanyaan yang relevan dan jawabannya diambil dari kutipan. Fokus pada detail penting. Output HANYA dalam format HTML dengan tag <strong> untuk pertanyaan dan tag <p> untuk jawaban. JANGAN sertakan judul, kategori, atau informasi lain di luar tag HTML.",
            'color' => '#008B8B'
        ]);

        DB::table('prompts')->insert([
            [
                'name' => 'rapikan_tambah_konten',
                'description' => 'Merapikan konten berita sesuai EYD, menambahkan detail, serta menghasilkan 3 alternatif judul.',
                'button_text' => 'Rapikan & Tambahkan',
                'color' => 'bg-purple-600 text-white',
                'prompt_template' => "Kamu adalah seorang editor berita profesional. 
Tugasmu:
1. Rapikan {konten} agar tata bahasa sesuai EYD dan enak dibaca.  
2. Tambahkan detail/konteks seperlunya (misalnya: lokasi, waktu, latar belakang singkat) untuk memperkaya konten.  
3. Gunakan gaya penulisan jurnalistik: ringkas, jelas, dan objektif.  
4. Bagi paragraf agar lebih rapi dan mudah dipahami.  
5. Jangan mengubah fakta yang sudah ada, hanya boleh melengkapi dengan informasi umum yang relevan.  
6. Buatkan 3 alternatif judul berita yang menarik dan memancing rasa ingin tahu pembaca, namun tetap informatif.  

Format keluaran wajib:
- Mulai dengan daftar judul alternatif dalam elemen <ul><li>Judul 1</li><li>Judul 2</li><li>Judul 3</li></ul>.  
- Setelah itu, tampilkan artikel berita dalam HTML murni.  
- Artikel harus dimulai dengan <p class='headline'><strong>Judul Terpilih</strong></p>.  
- Isi berita dibuat dengan paragraf <p> terpisah.  
- Jika ada kutipan narasumber, gunakan tanda kutip.  
- Tutup dengan kredit penulis jika tersedia.  
- Jangan gunakan pemisah markdown seperti ```html, ``` atau ***. Output harus berupa HTML murni saja.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}