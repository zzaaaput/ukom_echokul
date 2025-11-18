<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $table = 'kehadiran';
    
    protected $fillable = [
        'anggota_ekskul_id',
        'kegiatan_id',
        'tanggal',
        'status',
        'bukti_kehadiran',
        'dicatat_oleh',
    ];

    public function anggota()
    {
        return $this->belongsTo(AnggotaEkstrakurikuler::class, 'anggota_ekskul_id');
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}
