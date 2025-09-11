<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prompts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama unik untuk prompt (misal: 'berita_lokal')
            $table->string('description', 500)->nullable(); // Deskripsi singkat tentang prompt
            $table->string('button_text'); // Teks yang akan ditampilkan di tombol
            $table->text('color')->nullable(); // Warna khusus untuk tombol (opsional)
            $table->text('prompt_template'); // Isi template prompt
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompts');
    }
};
