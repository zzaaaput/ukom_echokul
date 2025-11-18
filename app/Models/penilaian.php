<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'penilaians';

    protected $fillable = [
        'anggota_id',
        'ekstrakurikuler_id',
        'tahun_ajaran',
        'semester',
        'keterangan',
        'catatan',
        'foto',
        'dibuat_oleh'
    ];

    public function anggota()
    {
        return $this->belongsTo(AnggotaEkstrakurikuler::class, 'anggota_id');
    }

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id');
    }
}
