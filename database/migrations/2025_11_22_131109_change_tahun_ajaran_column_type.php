<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('anggota_ekstrakurikuler', function (Blueprint $table) {
            $table->string('tahun_ajaran', 10)->change();
        });
    }

    public function down()
    {
        Schema::table('anggota_ekstrakurikuler', function (Blueprint $table) {
            $table->year('tahun_ajaran')->change();
        });
    }

};
