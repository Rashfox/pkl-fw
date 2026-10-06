<?php

namespace App\Imports;

use App\Models\Dosen;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DosenImport implements ToModel, WithStartRow
{
    public function model(array $row): Model|null
    {
        if (count($row) < 5 || empty($row[0]) || empty($row[1])) {
            return null;
        }
        $dosen = Dosen::where('nik', $row[1])->first();
        if ($dosen) {
            return null;
        }
        return new Dosen([
            'nik' => $row[1],
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
