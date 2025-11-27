<?php

namespace App\Exports;

use App\Models\AnggotaEkstrakurikuler;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AnggotaExport implements FromCollection, WithHeadings, WithMapping
{
    protected $ekskulId;

    public function __construct($ekskulId)
    {
        $this->ekskulId = $ekskulId;
    }

    public function collection()
    {
        return AnggotaEkstrakurikuler::with('user', 'ekstrakurikuler')
                ->where('ekstrakurikuler_id', $this->ekskulId)
                ->orderBy('nama_anggota')
                ->get();
    }

    public function map($a): array
    {
        return [
            $a->nama_anggota,
            $a->user?->nama_lengkap,
            $a->jabatan,
            $a->ekstrakurikuler?->nama_ekskul,
            $a->status_anggota,
            $a->tahun_ajaran,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Anggota',
            'Nama Siswa',
            'Jabatan',
            'Ekskul',
            'Status',
            'Tahun Ajaran'
        ];
    }
}