<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perlombaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ekstrakurikuler_id')->constrained('ekstrakurikuler')->cascadeOnDelete();
            $table->string('nama_perlombaan');
            $table->string('tingkat')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('tempat')->nullable();
            $table->text('deskripsi')->nullable();
            $table->year('tahun_ajaran')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perlombaan');
    }
};
