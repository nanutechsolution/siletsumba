# Silet Sumba

[![Status](https://img.shields.io/badge/status-active-success.svg)]()
[![License](https://img.shields.io/badge/license-MIT-blue.svg)]()
[![Made by](https://img.shields.io/badge/made%20by-NanutechSolution-orange.svg)]()

> **Silet Sumba** — Portal berita lokal untuk Sumba dan Nusa Tenggara Timur. Tajam pada fakta, hangat pada budaya.

---

## Ringkasan singkat

Silet Sumba adalah situs berita lokal yang dirancang untuk menyajikan laporan mendalam, liputan adat, dan informasi praktis bagi masyarakat Sumba dan sekitarnya. Fokus kami: akurasi, kecepatan, inovasi, dan menghormati kearifan lokal.

## Fitur utama

* Liputan berita lokal (politik, adat, komunitas, keamanan, ekonomi mikro)
* Halaman artikel dengan SEO-friendly metadata
* Sistem kategori & tag
* Penulis multi-user dengan level peran (Admin / Editor / Contributor)
* Manajemen media (gambar & video)
* Komentar (opsional: termoderasi)
* Newsletter / subscribe (opsional)
* Integrasi sosial media (share & embed)
* Support untuk mobile-first responsive design

### 🤖 Fitur AI

* **Auto Description**: sistem AI membaca artikel lalu menghasilkan deskripsi singkat yang SEO-friendly.
* **AI Opinion**: memberikan opini netral atau perspektif tambahan untuk memperkaya sudut pandang pembaca.
* **Content Helper**: membantu jurnalis/editor menyusun draft artikel lebih cepat.
* **Moderasi Komentar (opsional)**: AI dapat memfilter spam atau komentar bermuatan negatif.

> AI diintegrasikan dengan model NLP modern (OpenAI / HuggingFace) dan dapat dikustomisasi sesuai konteks lokal (Bahasa Indonesia & dialek Sumba).

## Tech stack

* **Framework**: Laravel 12 (PHP 8.2+)
* **Frontend**: Blade, TailwindCSS, Alpine.js (bisa ditambah React/Vue jika perlu)
* **Database**: MySQL / MariaDB
* **Storage**: Local / S3-compatible
* **AI Integration**: OpenAI API (GPT models)
* **CI/CD**: GitHub Actions

## Struktur proyek

```
/ (root)
├─ app/
│   ├─ Http/
│   ├─ Models/
│   └─ Services/       # integrasi AI
├─ bootstrap/
├─ config/
├─ database/
│   ├─ migrations/
│   └─ seeders/
├─ public/
├─ resources/
│   ├─ views/
│   └─ css/js
├─ routes/
│   └─ web.php
├─ tests/
├─ .env.example
├─ composer.json
└─ README.md
```

## Langkah cepat (Quick Start)

### 1. Clone repository

```bash
git clone https://github.com/nanutechsolution/siletsumba.git
cd siletsumba
```

### 2. Install dependency

```bash
composer install
npm install && npm run build
```

### 3. Konfigurasi environment

Salin file `.env.example` ke `.env`:

```bash
cp .env.example .env
```

Lalu isi dengan konfigurasi database & AI API Key:

```
APP_NAME=SiletSumba
APP_ENV=local
APP_KEY=
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=siletsumba
DB_USERNAME=root
DB_PASSWORD=

OPENAI_API_KEY=your_openai_api_key
```

### 4. Generate key

```bash
php artisan key:generate
```

### 5. Jalankan migrasi & seeder

```bash
php artisan migrate --seed
```

### 6. Jalankan server

```bash
php artisan serve
```

Akses di `http://localhost:8000`

---

## Integrasi AI di Laravel

Buat service baru: `app/Services/AIService.php`

```php
namespace App\Services;

use OpenAI;

class AIService
{
    protected $client;

    public function __construct()
    {
        $this->client = OpenAI::client(env('OPENAI_API_KEY'));
    }

    public function generateDescription(string $content): string
    {
        $result = $this->client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'Buat deskripsi berita singkat dan SEO-friendly'],
                ['role' => 'user', 'content' => $content],
            ],
        ]);

        return $result->choices[0]->message->content ?? '';
    }
}
```

Contoh penggunaan di Controller:

```php
use App\Services\AIService;

public function store(Request $request, AIService $ai)
{
    $content = $request->input('content');
    $description = $ai->generateDescription($content);

    Article::create([
        'title' => $request->title,
        'content' => $content,
        'description' => $description,
    ]);
}
```

---

## Testing

```bash
php artisan test
```

## Deployment

* Gunakan Laravel Forge / Envoyer atau manual ke VPS
* Pastikan queue worker aktif jika menggunakan job untuk AI request
* Setup cache & storage (Redis, S3, dsb.)

## Security best practices

* Jangan commit secret ke Git
* Gunakan `.env` dan `.gitignore`
* Validasi & sanitasi input user (prevent XSS/SQLi)
* Batasi upload file type & size

## License

MIT © NanutechSolution

## Kontak

* Maintainer: NanutechSolution / Ranus
* Email: `your-email@example.com`
* Repo: [https://github.com/nanutechsolution/siletsumba](https://github.com/nanutechsolution/siletsumba)

## Acknowledgements

Terima kasih pada kontributor, komunitas Sumba, dan pihak yang mendukung pelestarian budaya lokal.

---

> *Notes*: README ini sudah diadaptasi untuk **Laravel 12** dengan integrasi **AI (OpenAI)**. Pastikan library OpenAI PHP SDK sudah diinstall (`composer require openai-php/client`).
