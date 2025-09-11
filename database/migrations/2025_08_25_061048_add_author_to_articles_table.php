<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'author')) {
                $table->dropColumn('author');
            }
            // Tambahkan relasi ke users
            $table->foreignId('user_id')
                ->after('category_id')
                ->constrained()
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            Schema::table('articles', function (Blueprint $table) {
                // Balikin kolom author kalau rollback
                $table->string('author')->nullable()->after('category_id');

                // Drop relasi ke users
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        });
    }
};
