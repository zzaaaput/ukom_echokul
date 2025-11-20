<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'user_id',
        'judul_pengumuman',
        'isi',
        'tanggal',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}