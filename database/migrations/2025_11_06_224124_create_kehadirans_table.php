<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_ekskul_id')->constrained('anggota_ekstrakurikuler')->cascadeOnDelete();
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->cascadeOnDelete();
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'sakit', 'izin', 'alpa'])->default('hadir');
            $table->text('keterangan')->nullable();
            $table->string('bukti_kehadiran')->nullable();
            $table->foreignId('dicatat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['anggota_ekskul_id', 'kegiatan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kehadiran');
    }
};
