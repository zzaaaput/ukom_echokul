<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perlombaan extends Model
{
    use HasFactory;

    protected $table = 'perlombaan';

    protected $fillable = [
        'ekstrakurikuler_id',
        'nama_perlombaan',
        'tanggal',
        'tingkat',
        'tempat',
        'tahun_ajaran',
        'deskripsi',
        'foto'
    ];

    public function ekstrakurikuler()
{
    return $this->belongsTo(Ekstrakurikuler::class);
}

}
