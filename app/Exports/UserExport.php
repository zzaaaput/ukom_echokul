<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class UserExport implements FromCollection, WithHeadings, WithMapping, WithDrawings
{
    private $rowNumber = 2; 
    public function collection()
    {
        return User::orderBy('nama_lengkap')->get();
    }

    public function map($user): array
    {
        $this->rowNumber++;

        return [
            $user->nama_lengkap,
            '', 
            $user->email,
            ucfirst($user->role),
            $user->status_aktif ? 'Aktif' : 'Tidak Aktif',
            $user->created_at?->format('d-m-Y H:i'),
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Foto',
            'Email',
            'Role',
            'Status Akun',
            'Dibuat Pada',
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $row = 2;

        foreach (User::orderBy('nama_lengkap')->get() as $user) {

            if (!$user->foto || !file_exists(public_path($user->foto))) {
                $row++;
                continue;
            }

            $drawing = new Drawing();
            $drawing->setName('Foto User');
            $drawing->setPath(public_path($user->foto)); 
            $drawing->setHeight(50);
            $drawing->setCoordinates('B' . $row); 

            $drawings[] = $drawing;
            $row++;
        }

        return $drawings;
    }
}