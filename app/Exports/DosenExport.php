<?php

namespace App\Exports;

use App\Models\Dosen;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DosenExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
{
    public function collection(): Collection
    {
        return Dosen::all();
    }
    public function map($dosen):array{
        $kelamin = ($dosen->kelamin=='l')?'Laki-laki':'Perempuan';
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
            ['Data Dosen'],
            [],
            ['NIk',
            'Nama dosen',
            'Kontak',
            'Email',
            'Jenis Kelamin']
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $highestRow = $sheet->getHighestRow();
        $sheet->mergeCells('A1:E2');
        $sheet->getStyle('A1:E2')->applyFromArray([
            'font' => [
                'size' => 16,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);
        $sheet->getStyle('A3:E' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ]);
        
        $sheet->getStyle('A1:E3')->getFont()->setBold(true);
        return [];
    }
    public function title(): string
    {
        return 'Data Dosen';
    }
}
