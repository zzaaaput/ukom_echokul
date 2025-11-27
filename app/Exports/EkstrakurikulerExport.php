<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;

class EkstrakurikulerExport implements FromCollection
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $rows = [];

        $rows[] = [
            'Nama Ekstrakurikuler',
            'Pembina',
            'Ketua',
            'Deskripsi'
        ];

        foreach ($this->data as $e) {
            $rows[] = [
                $e->nama_ekstrakurikuler,
                $e->pembina->nama_lengkap ?? '-',
                $e->ketua->nama_lengkap ?? '-',
                $e->deskripsi
            ];
        }

        return collect($rows);
    }
}