<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
{
    public function collection(): Collection
    {
        return Mahasiswa::all();
    }
    public function map($mahasiswa):array{
        $kelamin = ($mahasiswa->kelamin=='l')?'Laki-laki':'Perempuan';
        $status = ($mahasiswa->status=='1')?'Aktif':'Tidak Aktif';
        return [
            $mahasiswa->nim,
            $mahasiswa->nama,
            $mahasiswa->kontak,
            $mahasiswa->email,
            $kelamin,
            $status
        ];
    }
    public function headings(): array
    {
        return [
            ['Data Mahasiswa'],
            [],
            ['NIM',
            'Nama Mahasiswa',
            'Kontak',
            'Email',
            'Jenis Kelamin',
            'Status']
        ];
    }
    public function styles(Worksheet $sheet): array
    {
        $highestRow = $sheet->getHighestRow();
        $sheet->mergeCells('A1:F2');
        $sheet->getStyle('A1:F2')->applyFromArray([
            'font' => [
                'size' => 16,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);
        $sheet->getStyle('A3:F' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ]);
        
        $sheet->getStyle('A1:F3')->getFont()->setBold(true);
        return [];
    }
    public function title ():string
    {
        return 'Data Mahasiswa';
    }
}
