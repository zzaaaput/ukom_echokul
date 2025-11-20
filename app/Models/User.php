<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'role',
        'foto',
        'session_aktif',
        'status_aktif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | ROLE CHECKERS (string-based, sesuai migration)
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPembina(): bool
    {
        return $this->role === 'pembina';
    }

    public function isKetua(): bool
    {
        return $this->role === 'ketua';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function ekstrakurikulerDibina()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id'. 'pembina_id');
    }
    public function isPembinaOf($ekskulId)
    {
        return $this->ekstrakurikulerDibina()->where('id', $ekskulId)->exists();
    }

    public function keanggotaan()
    {
        return $this->hasMany(AnggotaEkstrakurikuler::class, 'user_id');
    }

    public function ekstrakurikulerAktif()
    {
        return $this->keanggotaan()
                    ->where('status_anggota', 'aktif')
                    ->with('ekstrakurikuler');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER METHODS
    |--------------------------------------------------------------------------
    */
    public function ekstrakurikulerDipimpin()
    {
        return $this->hasOne(Ekstrakurikuler::class, 'user_ketua_id');
    }

    public function isKetuaOf(int $ekskulId): bool
    {
        return $this->keanggotaan()
                    ->where('ekstrakurikuler_id', $ekskulId)
                    ->where('jabatan', 'ketua')
                    ->where('status_anggota', 'aktif')
                    ->exists();
    }

    public function getDashboardRoute(): string
    {
        return match($this->role) {
            'admin' => 'dashboard.admin',
            'pembina' => $this->ekstrakurikulerDibina ? 'dashboard.pembina.index' : 'dashboard.siswa.index',
            'ketua' => $this->ekstrakurikulerDipimpin() ? 'dashboard.ketua.index' : 'dashboard.siswa.index',
            default => 'dashboard.siswa.index',
        };
    }
    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

}