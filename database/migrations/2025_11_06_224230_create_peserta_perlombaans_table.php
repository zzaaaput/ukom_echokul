<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta_perlombaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perlombaan_id')->constrained('perlombaan')->cascadeOnDelete();
            $table->foreignId('anggota_id')->constrained('anggota_ekstrakurikuler')->cascadeOnDelete();
            $table->string('peran')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['perlombaan_id', 'anggota_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_perlombaan');
    }
};
