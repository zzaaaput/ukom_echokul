<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ekstrakurikuler extends Model
{
    protected $table = 'ekstrakurikuler';
        protected $fillable = [
        'user_pembina_id',
        'user_ketua_id',
        'nama_ekstrakurikuler',
        'deskripsi',
        'foto',
    ];

    public function pembina(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_pembina_id');
    }

    public function anggota(): HasMany
    {
        return $this->hasMany(AnggotaEkstrakurikuler::class, 'ekstrakurikuler_id');
    }

    public function anggotaAktif()
    {
        return $this->hasMany(AnggotaEkstrakurikuler::class, 'ekstrakurikuler_id')
                    ->where('status_anggota', 'aktif');
    }

    public function ketua()
    {
        return $this->belongsTo(User::class, 'user_ketua_id');
    }
    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'ekstrakurikuler_id');
    }

}
