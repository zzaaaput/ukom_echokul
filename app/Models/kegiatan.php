<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'ekstrakurikuler_id',
        'nama_kegiatan',
        'deskripsi',
        'lokasi',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'foto',
        'dibuat_oleh'
    ];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}