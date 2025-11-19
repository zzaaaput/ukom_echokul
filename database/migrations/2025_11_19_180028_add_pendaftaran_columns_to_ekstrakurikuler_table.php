<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            $table->date('pendaftaran_mulai')->nullable()->after('deskripsi');
            $table->date('pendaftaran_selesai')->nullable()->after('pendaftaran_mulai');
            // optional boolean to quickly enable/disable, berguna juga
            $table->boolean('pendaftaran_dibuka')->default(false)->after('pendaftaran_selesai');
        });
    }

    public function down(): void
    {
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            $table->dropColumn(['pendaftaran_mulai', 'pendaftaran_selesai', 'pendaftaran_dibuka']);
        });
    }
};
