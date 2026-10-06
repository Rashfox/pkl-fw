<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

class MahasiswaImportTest extends TestCase
{
    public function test_mahasiswa_import_accepts_file_excel_and_creates_records(): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray([
            ['NIM', 'Nama Mahasiswa', 'Kontak', 'Email', 'Jenis Kelamin'],
            ['20230101', 'Budi Santoso', '081234567890', 'budi@example.com', 'L'],
        ], null, 'A1');

        $tempPath = tempnam(sys_get_temp_dir(), 'excel');
        (new Xlsx($spreadsheet))->save($tempPath);

        $file = new UploadedFile(
            $tempPath,
            'mahasiswa.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->from(route('impor.mahasiswa'))->post(route('impor.mahasiswa'), [
            'file_excel' => $file,
        ]);

        $response->assertSessionHas('sukses', 'Data berhasil diimpor!');
        $this->assertDatabaseHas('mahasiswa', [
            'nim' => '20230101',
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
        ]);
        $this->assertTrue(Mahasiswa::where('nim', '20230101')->exists());
    }
}
