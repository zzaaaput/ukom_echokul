<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case PEMBINA = 'pembina';
    case KETUA = 'ketua';
    case SISWA = 'siswa';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}