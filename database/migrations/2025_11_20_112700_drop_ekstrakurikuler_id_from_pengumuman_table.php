<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            // Hapus foreign key dulu jika ada
            $table->dropForeign(['ekstrakurikuler_id']);
            // Hapus kolom
            $table->dropColumn('ekstrakurikuler_id');
        });
    }

    public function down(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            // Tambahkan kembali kolom jika rollback
            $table->foreignId('ekstrakurikuler_id')
                  ->nullable()
                  ->constrained('ekstrakurikuler')
                  ->nullOnDelete();
        });
    }
};