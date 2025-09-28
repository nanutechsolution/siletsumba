<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menonaktifkan pemeriksaan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Mengosongkan tabel yang memiliki foreign key
        Article::truncate();

        // Mengaktifkan kembali pemeriksaan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $articles = [
            // Berita 1: Investigasi (Silet Sumba)
            [
                'title' => 'Proyek Sumur Bor Mangkrak, Warga Desa di Sumba Timur Krisis Air Bersih',
                'is_published' => true,
                'content' => '<p>WAINGAPU — Proyek pembangunan sumur bor di Desa Elar, Sumba Timur, senilai Rp 500 juta kini mangkrak. Proyek vital ini terhenti sejak tiga bulan lalu, menyisakan tumpukan material yang tak berguna. Akibatnya, ratusan warga kembali menghadapi krisis air bersih, dan harus menempuh jarak 3 km untuk mendapatkan air.</p><p>Seorang warga, Rato (55), mengungkapkan kekecewaannya. "Kami sudah mengeluh berkali-kali, tapi tidak ada respons. Jangankan air, janji saja tidak ada," ujarnya dengan nada putus asa. Kontraktor proyek diduga menghilang dan tidak bisa dihubungi pihak desa.</p><p>Maria (42), seorang ibu rumah tangga, juga merasakan dampak buruknya. "Ini proyek vital bagi kami, tapi sekarang hanya jadi tumpukan besi tak berguna," katanya. Kasus ini kini tengah diselidiki oleh dinas terkait, namun belum ada kejelasan kapan proyek akan dilanjutkan.</p>',
                'location_short' => 'Elar, Sumba Timur',
                'is_breaking' => true,
                'views' => 15200,
                'likes' => 450,
            ],
            // Berita 2: Budaya
            [
                'title' => 'Makna di Balik Tradisi Pasola, Tontonan Penuh Ketenangan Batin di Sumba',
                'is_published' => true,
                'content' => '<p>SUMBA BARAT DAYA — Ritual Pasola kembali digelar di Lapangan Adat Waihura, Sumba Barat Daya, menarik ribuan pasang mata, baik dari warga lokal maupun turis mancanegara. Pasola adalah ritual perang-perangan antara dua kelompok ksatria berkuda yang saling melempar lembing kayu. Namun, di balik ketegangan ritual, tersimpan makna mendalam tentang permohonan restu leluhur.</p><p>Umbu Kahi (60), seorang tokoh adat, menjelaskan bahwa Pasola bukan sekadar tontonan. "Pasola adalah permohonan kami kepada leluhur agar tanah subur dan panen berhasil," katanya. Ketenangan hati dan keberanian adalah nilai utama yang dijunjung tinggi selama ritual.</p><p>Acara ini juga menjadi ajang promosi pariwisata. Kepala Dinas Pariwisata Sumba Barat Daya menyatakan, "Kami sangat bangga bisa menampilkan tradisi ini kepada dunia. Ini adalah cerminan kekayaan budaya kita."</p>',
                'location_short' => 'Sumba Barat Daya',
                'is_breaking' => false,
                'views' => 9850,
                'likes' => 320,
            ],
            // Berita 3: Berita Lokal
            [
                'title' => 'Jalan Rusak Parah di Waingapu Sebabkan Kemacetan dan Keluhan Warga',
                'is_published' => true,
                'content' => '<p>WAINGAPU — Kondisi jalan rusak parah di beberapa titik Kota Waingapu kembali menuai keluhan dari masyarakat. Lubang-lubang besar di jalan utama sering menyebabkan kemacetan dan kecelakaan kecil, terutama saat musim hujan.</p><p>Jalur menuju Pelabuhan Waingapu menjadi salah satu titik terparah. Pengendara motor dan mobil harus ekstra hati-hati. Warga berharap pemerintah segera mengambil tindakan untuk memperbaiki infrastruktur yang vital ini.</p>',
                'location_short' => 'Waingapu',
                'is_breaking' => false,
                'views' => 7300,
                'likes' => 180,
            ],
            // Berita 4: Lingkungan
            [
                'title' => 'Petani Sumba Mulai Beralih ke Pertanian Organik, Dukungan Pemerintah Diharapkan',
                'is_published' => true,
                'content' => '<p>SUMBA BARAT — Kesadaran akan pentingnya pertanian ramah lingkungan mulai tumbuh di kalangan petani Sumba. Sejumlah kelompok petani di Sumba Barat mulai mencoba metode organik, mengurangi penggunaan pupuk dan pestisida kimia. Langkah ini bertujuan menjaga kesuburan tanah dan menghasilkan produk yang lebih sehat.</p><p>Salah satu petani, Imanuel (45), mengatakan bahwa hasil panen dengan metode organik memang sedikit berbeda, namun kualitasnya lebih baik. "Kami berharap ada dukungan dari pemerintah, baik itu dalam hal bibit, pelatihan, atau pemasaran," ujarnya.</p>',
                'location_short' => 'Sumba Barat',
                'is_breaking' => false,
                'views' => 4500,
                'likes' => 95,
            ],
            // Berita 5: Sosial
            [
                'title' => 'Ratusan Mahasiswa Sumba Gelar Aksi Damai, Tuntut Penyelesaian Sengketa Tanah',
                'is_published' => true,
                'content' => '<p>WAINGAPU — Ratusan mahasiswa yang tergabung dalam Aliansi Mahasiswa Peduli Sumba menggelar aksi damai di depan Kantor Bupati Sumba Timur. Mereka menuntut pemerintah daerah untuk menuntaskan sengketa lahan adat yang tak kunjung selesai.</p><p>Aksi ini berlangsung tertib dan mendapat pengawalan ketat dari kepolisian. Perwakilan mahasiswa sudah diterima oleh Sekretaris Daerah untuk berdialog, meskipun belum ada kesepakatan final, pihak pemerintah berjanji akan menindaklanjuti tuntutan tersebut.</p>',
                'location_short' => 'Waingapu',
                'is_breaking' => false,
                'views' => 12100,
                'likes' => 512,
            ],
            // Berita 6: Promosi (AIDA Lokal)
            [
                'title' => 'Nikmati Keindahan Tersembunyi Pantai Watu Parunu, Surga Baru di Sumba',
                'is_published' => true,
                'content' => '<p>SUMBA — Pernahkah Anda membayangkan berlibur di pantai dengan tebing karang yang menjulang tinggi, ombak yang tenang, dan hamparan pasir putih bersih? Pantai Watu Parunu menawarkan semua itu! Destinasi wisata tersembunyi ini adalah surga bagi para pencari ketenangan dan keindahan alam. Jangan lewatkan keindahan matahari terbenam yang memukau di sini. Segera rencanakan perjalanan Anda dan jadikan Watu Parunu bagian dari cerita liburan Anda. Kunjungi Sumba, kunjungi Watu Parunu!</p>',
                'location_short' => 'Watu Parunu',
                'is_breaking' => false,
                'views' => 6400,
                'likes' => 289,
            ],
            // Berita 7: Draft
            [
                'title' => 'Persiapan Festival Kuda Sandelwood Terkendala Anggaran, Panitia Berharap Donasi',
                'is_published' => false,
                'content' => '<p>WAINGAPU — Panitia Festival Kuda Sandelwood 2025 mengungkapkan bahwa persiapan mereka menghadapi kendala anggaran. Meskipun antusiasme masyarakat tinggi, kekurangan dana membuat beberapa rangkaian acara terancam dibatalkan. Panitia saat ini sedang membuka donasi dari masyarakat maupun pihak swasta.</p>',
                'location_short' => 'Waingapu',
                'is_breaking' => false,
                'views' => 1100,
                'likes' => 15,
            ],
            // Berita 8: Investigasi (Silet Sumba)
            [
                'title' => 'Dugaan Pungutan Liar Dana Bantuan Sosial Gegerkan Warga Desa',
                'is_published' => true,
                'content' => '<p>KODI UTARA — Dugaan pungutan liar yang melibatkan oknum perangkat desa di Kodi Utara mencuat ke publik. Dana bantuan sosial yang seharusnya disalurkan utuh kepada masyarakat justru dipotong. Warga yang berani berbicara mengaku diintimidasi. Kasus ini telah dilaporkan ke pihak berwajib dan diharapkan dapat segera diusut tuntas.</p>',
                'location_short' => 'Kodi Utara',
                'is_breaking' => true,
                'views' => 18000,
                'likes' => 670,
            ],
            // Berita 9: Budaya (Draft)
            [
                'title' => 'Mengenal Kain Tenun Ikat Sumba, Simbol Kekayaan Budaya yang Mendunia',
                'is_published' => false,
                'content' => '<p>SUMBA — Kain tenun ikat Sumba bukan sekadar kain, melainkan media cerita tentang kehidupan, mitologi, dan status sosial. Setiap motif memiliki makna dan sejarah yang dalam, diwariskan secara turun-temurun. Proses pembuatannya yang rumit dan memakan waktu menjadikannya salah satu warisan budaya tak benda yang paling berharga di Indonesia.</p>',
                'location_short' => 'Seluruh Sumba',
                'is_breaking' => false,
                'views' => 320,
                'likes' => 50,
            ],
            // Berita 10: Berita Lokal
            [
                'title' => 'Pemerintah Kabupaten Sumba Tengah Gelar Rapat Koordinasi, Bahas Peningkatan Kualitas Pendidikan',
                'is_published' => true,
                'content' => '<p>SUMBA TENGAH — Pemerintah Kabupaten Sumba Tengah mengadakan Rapat Koordinasi dengan seluruh kepala sekolah dan dinas terkait. Fokus utama rapat adalah membahas strategi peningkatan kualitas pendidikan, termasuk perbaikan fasilitas sekolah dan peningkatan kompetensi guru. Rapat ini diharapkan dapat menghasilkan langkah-langkah konkret untuk kemajuan pendidikan di Sumba Tengah.</p>',
                'location_short' => 'Sumba Tengah',
                'is_breaking' => false,
                'views' => 2500,
                'likes' => 85,
            ],
        ];

        foreach ($articles as $articleData) {
            Article::create([
                'title' => $articleData['title'],
                'slug' => Str::slug($articleData['title']),
                'content' => $articleData['content'],
                'location_short' => $articleData['location_short'],
                'is_breaking' => $articleData['is_breaking'],
                'category_id' => Category::inRandomOrder()->first()->id,
                'user_id' => User::inRandomOrder()->first()->id,
                'views' => $articleData['views'],
                'likes' => $articleData['likes'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
