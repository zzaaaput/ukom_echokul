<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaEkstrakurikuler extends Model
{
    use HasFactory;

    protected $table = 'anggota_ekstrakurikuler';

    protected $fillable = [
        'user_id',
        'ekstrakurikuler_id',
        'nama_anggota',
        'jabatan',
        'tahun_ajaran',
        'status_anggota',
        'foto',
        'tanggal_gabung',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }
}