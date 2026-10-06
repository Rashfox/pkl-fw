<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MahasiswaImport implements ToModel, WithStartRow
{
    public function model(array $row): Model|null
    {
        if (count($row) < 5 || empty($row[0]) || empty($row[1])) {
            return null;
        }
        $mahasiswa = Mahasiswa::where('nim', $row[1])->first();
        if ($mahasiswa) {
            return null;
        }
        return new Mahasiswa([
            'nim' => $row[1],
            'nama' => $row[2],
            'kontak' => $row[3],
            'email' => $row[4],
            'kelamin' => strtolower((string) $row[5]),
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
