<?php

namespace Database\Seeders;

use App\Models\Prompt;
use Illuminate\Database\Seeder;

class PromptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menghapus data lama untuk mencegah duplikasi
        Prompt::truncate();

        // 1. Tombol Generate Berita Lokal (Faktual & Umum)
        Prompt::create([
            'name' => 'berita_lokal',
            'button_text' => 'Generate Berita Lokal',
            'description' => 'Membuat artikel berita umum yang lugas, profesional, dan faktual. Ideal untuk semua laporan berita harian.',
            'prompt_template' => "Bertindaklah sebagai jurnalis profesional di Sumba. Buat artikel berita yang lugas dan faktual dari data berikut: Judul: {title}, Kategori: {category}, Lokasi: {location}, Fakta/Kronologi: {facts}, Kutipan/Narasumber: {quotes}. Sertakan konteks sosial atau dampak bagi masyarakat jika relevan. Output HANYA dalam format HTML tanpa markdown.",
            'color' => '#800080'
        ]);

        // 2. Tombol Silet Sumba (Investigasi & Tajam)
        Prompt::create([
            'name' => 'silet_sumba',
            'button_text' => 'Silet Sumba',
            'description' => 'Membuat artikel dengan gaya ringkas, tajam, dan langsung ke inti masalah. Cocok untuk berita investigasi atau isu-isu kontroversial.',
            'prompt_template' => "Sebagai jurnalis Silet Sumba, buatlah artikel yang ringkas dan tajam. Masukkan informasi ini: Judul: {title}, Kategori: {category}, Lokasi: {location}, Fakta: {facts}, Kutipan: {quotes}. Fokus pada inti masalah dan buatlah gaya tulisan yang lugas. Gunakan bold, italic, atau underline untuk menekankan poin penting. Output HANYA dalam format HTML.",
            'color' => '#0000FF'
        ]);

        // 3. Tombol Liputan Budaya (Mendalam & Informatif)
        Prompt::create([
            'name' => 'liputan_budaya',
            'button_text' => 'Liputan Budaya',
            'description' => 'Menulis laporan mendalam tentang tradisi, seni, atau event budaya lokal. Menyoroti keunikan dan makna di baliknya.',
            'prompt_template' => "Tulis laporan mendalam tentang budaya Sumba. Buat artikel yang informatif dan menarik berdasarkan informasi: Judul: {title}, Kategori: {category}, Lokasi: {location}, Fakta: {facts}, Kutipan: {quotes}. Soroti keunikan tradisi, makna di baliknya, dan perannya bagi masyarakat modern. Gunakan subjudul untuk membagi topik. Output HANYA dalam format HTML.",
            'color' => '#228B22'
        ]);

        // 4. Tombol Tulis Opini (Kolom Opini & Perspektif)
        Prompt::create([
            'name' => 'tulis_opini',
            'button_text' => 'Tulis Opini',
            'description' => 'Membuat artikel opini dengan sudut pandang yang kuat dan mencerminkan perspektif lokal. Ideal untuk kolom yang memancing diskusi.',
            'prompt_template' => "Tulis artikel opini dengan sudut pandang kolumnis Sumba. Berikan pendapat tajam dan terstruktur berdasarkan informasi berikut: Judul: {title}, Kategori: {category}, Lokasi: {location}, Fakta: {facts}, Kutipan: {quotes}. Gunakan teks bold/italic untuk highlight pendapat penting. Output HANYA dalam format HTML.",
            'color' => '#FF0000'
        ]);

        // 5. Tombol Promosi Lokal (Copywriting AIDA)
        Prompt::create([
            'name' => 'promosi_lokal',
            'button_text' => 'Promosi Lokal (AIDA)',
            'description' => 'Membuat konten promosi yang persuasif untuk event, produk UMKM, atau tempat wisata menggunakan metode AIDA (Attention, Interest, Desire, Action).',
            'prompt_template' => "Bertindaklah sebagai copywriter lokal di Sumba. Buat konten promosi dengan metode AIDA (Attention, Interest, Desire, Action) menggunakan informasi berikut: Judul/Produk: {title}, Kategori: {category}, Lokasi: {location}, Fakta/Manfaat: {facts}. Tambahkan kutipan dari pelanggan/narasumber: {quotes}. Tulis dengan bahasa yang persuasif dan ajakan bertindak (call-to-action) yang jelas. Output HANYA dalam format HTML.",
            'color' => '#4B0082'
        ]);

        // 6. Tombol Ringkasan Kilat (Efisiensi Konten)
        Prompt::create([
            'name' => 'ringkasan_kilat',
            'button_text' => 'Ringkasan Kilat',
            'description' => 'Merangkum artikel berita panjang menjadi poin-poin utama dalam 2-3 paragraf. Ideal untuk ringkasan cepat.',
            'prompt_template' => "Buat ringkasan berita yang ringkas dan padat. Fokus pada inti berita, termasuk 5W+1H (Apa, Siapa, Kapan, Di mana, Mengapa, Bagaimana). Gunakan informasi berikut: Judul: {title}, Kategori: {category}, Lokasi: {location}, Fakta/Kronologi: {facts}. Output HANYA dalam format HTML, tidak lebih dari 3 paragraf.",
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
            'prompt_template' => "Tulis laporan khusus yang mendalam sebagai jurnalis Sumba. Kembangkan artikel dengan minimal 5 paragraf. Sisipkan subjudul yang relevan untuk memecah teks. Gunakan informasi ini: Judul: {title}, Kategori: {category}, Lokasi: {location}, Fakta: {facts}, Kutipan: {quotes}. Sertakan analisis dampak sosial atau ekonomi dari peristiwa tersebut bagi masyarakat Sumba. Output dalam format HTML yang terstruktur dengan baik.",
            'color' => '#8B4513'
        ]);

        // 9. Tombol Profil Tokoh (Humanis & Inspiratif)
        Prompt::create([
            'name' => 'profil_tokoh',
            'button_text' => 'Profil Tokoh',
            'description' => 'Membuat profil naratif tentang tokoh masyarakat, seniman, atau pahlawan lokal. Fokus pada sisi personal dan inspiratif.',
            'prompt_template' => "Buat profil naratif tentang tokoh inspiratif di Sumba. Gunakan informasi berikut: Judul: {title}, Kategori: {category}, Lokasi: {location}, Fakta: {facts}, Kutipan: {quotes}. Soroti perjalanan, tantangan, dan kontribusi tokoh tersebut bagi Sumba. Buatlah cerita yang personal dan menyentuh. Output dalam format HTML.",
            'color' => '#FFC0CB'
        ]);

        // 10. Tombol Wawancara AI (Interaktif & Terstruktur)
        Prompt::create([
            'name' => 'wawancara_ai',
            'button_text' => 'Wawancara AI',
            'description' => 'Menghasilkan draf wawancara dengan pertanyaan dan jawaban yang dirangkai secara logis dari fakta dan kutipan yang diberikan.',
            'prompt_template' => "Bertindaklah sebagai jurnalis Sumba yang sedang mewawancarai narasumber. Berdasarkan Kutipan: {quotes} dan Fakta: {facts}, buatlah skrip wawancara dengan format Tanya Jawab. Rangkai pertanyaan yang relevan dan jawabannya diambil dari kutipan. Fokus pada detail penting. Output HANYA dalam format HTML dengan tag <strong> untuk pertanyaan dan tag <p> untuk jawaban.",
            'color' => '#008B8B'
        ]);
    }
}
