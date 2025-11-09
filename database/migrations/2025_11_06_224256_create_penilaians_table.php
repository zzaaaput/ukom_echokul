<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggota_ekstrakurikuler')->cascadeOnDelete();
            $table->foreignId('ekstrakurikuler_id')->constrained('ekstrakurikuler')->cascadeOnDelete();
            $table->year('tahun_ajaran');
            $table->enum('semester', ['1','2','3','4','5','6']);
            $table->enum('keterangan', ['sangat baik','baik','cukup baik','cukup','kurang baik']);
            $table->text('catatan')->nullable();
            $table->foreignId('dibuat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['anggota_id','tahun_ajaran','semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
