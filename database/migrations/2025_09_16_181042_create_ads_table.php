<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul iklan
            $table->string('image')->nullable(); // Path gambar banner
            $table->string('url')->nullable(); // Link target iklan
            $table->enum('position', ['leaderboard', 'sidebar', 'skyscraper'])->default('sidebar'); // Posisi iklan
            $table->boolean('is_active')->default(true); // Status aktif
            $table->integer('views')->default(0); // Jumlah view
            $table->integer('clicks')->default(0); // Jumlah klik
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};