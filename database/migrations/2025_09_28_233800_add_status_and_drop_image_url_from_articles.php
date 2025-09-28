<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Tambah kolom status
            $table->enum('status', ['draft', 'scheduled', 'published', 'archived'])
                ->default('draft')
                ->after('is_published');
            // Hapus kolom image_url
            $table->dropColumn('image_url');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Balikin kolom image_url
            $table->string('image_url')->nullable()->after('excerpt');

            // Hapus kolom status
            $table->dropColumn('status');
        });
    }
};
