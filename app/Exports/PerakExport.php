<?php

namespace App\Exports;

use App\Models\Akademik;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PerakExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
{
    public function collection(): Collection
    {
        return Akademik::all();
    }
    public function map($akademik):array{
        return [
            $akademik->kode_akd,
            ($akademik->semester=='gl')?'Ganjil':'Genap',
            $akademik->tahun,
            ($akademik->is_active=='1')?'Aktif':'Tidak aktif'
        ];
    }
    public function headings(): array
    {
        return [
            ['Data Akademik'],
            [],
            ['Kode Akademik',
            'Semester',
            'Tahun',
            'Status']
        ];
    }
    public function styles(Worksheet $sheet): array
    {
        $highestRow = $sheet->getHighestRow();
        $sheet->mergeCells('A1:D2');
        $sheet->getStyle('A1:D2')->applyFromArray([
            'font' => [
                'size' => 16,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);
        $sheet->getStyle('A3:D' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ]);
        
        $sheet->getStyle('A1:D3')->getFont()->setBold(true);
        return [];
    }
    public function title(): string
    {
        return 'Data Akademik';
    }
}
