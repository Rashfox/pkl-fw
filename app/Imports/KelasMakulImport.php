<?php
namespace App\Imports;

use App\Models\KelasMakul;
use App\Models\DetailKelas;
use App\Models\Mahasiswa;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class KelasMakulImport implements OnEachRow, WithStartRow
{
    public function onRow(Row $row): void
    {
        $rowArray = $row->toArray();
        if (empty($rowArray[1]) || empty($rowArray[2]) || empty($rowArray[3]) || empty($rowArray[4]) || empty($rowArray[5])) {
            return;
        }
        $mhs = Mahasiswa::where('nim', $rowArray[6])->first();
        $kelas = KelasMakul::where('nama_kelas', $rowArray[1])
            ->where('kode_akd', $rowArray[2])
            ->where('kode_makul', $rowArray[3])
            ->where('kode_prodi', $rowArray[4])
            ->where('kode_dosen', $rowArray[5])
            ->first();
        if ($kelas) {
            if (!empty($rowArray[6])) {
                if ($mhs) {
                    DetailKelas::firstOrCreate([
                        'id_kelas' => $kelas->id,
                        'nim'      => $rowArray[6],
                    ]);
                }
            }
        }
        $kelas = KelasMakul::firstOrCreate(
            [
                'nama_kelas' => $rowArray[1],
                'kode_akd'   => $rowArray[2],
                'kode_makul' => $rowArray[3],
                'kode_prodi' => $rowArray[4],
                'kode_dosen' => $rowArray[5],
            ]
        );
        if (!empty($rowArray[6])) {
            if ($mhs) {
                DetailKelas::firstOrCreate([
                    'id_kelas' => $kelas->id,
                    'nim'      => $rowArray[6],
                ]);
            }
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}