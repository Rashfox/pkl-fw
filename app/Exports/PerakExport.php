<?php

namespace App\Exports;

use App\Models\Akademik;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PerakExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
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
            'Kode Akademik',
            'Semester',
            'Tahun',
            'Status'
        ];
    }
    public function styles(Worksheet $sheet): array
    {
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:D' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ]);
        
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
        return [];
    }
}
