<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota_ekstrakurikuler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('ekstrakurikuler_id')->constrained('ekstrakurikuler')->cascadeOnDelete();
            $table->string('nama_anggota');
            $table->enum('jabatan', ['anggota', 'pengurus', 'ketua'])
                  ->default('anggota');
            $table->year('tahun_ajaran');
            $table->enum('status_anggota', ['aktif', 'tidak aktif'])->default('aktif');
            $table->string('foto')->nullable();
            $table->date('tanggal_gabung')->default(now());
            $table->timestamps();

            $table->unique(['user_id', 'ekstrakurikuler_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_ekstrakurikuler');
    }
};
