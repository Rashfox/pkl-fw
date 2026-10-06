<?php

namespace App\Exports;

use App\Models\Dosen;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DosenExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection(): Collection
    {
        return Dosen::all();
    }
    public function map($dosen):array{
        $kelamin = ($dosen->kelamin=='l')?'Laki-laki':'Perempuan';
        $status = ($dosen->status=='1')?'Aktif':'Tidak Aktif';
        return [
            $dosen->nik,
            $dosen->nama,
            $dosen->kontak,
            $dosen->email,
            $kelamin
        ];
    }

    public function headings(): array
    {
        return [
            'NIk',
            'Nama dosen',
            'Kontak',
            'Email',
            'Jenis Kelamin'
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:E' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ]);
        
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        return [];
    }
}
