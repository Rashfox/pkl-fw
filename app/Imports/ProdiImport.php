<?php

namespace App\Imports;

use App\Models\Prodi;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProdiImport implements ToModel, WithStartRow
{
    public function model(array $row): Model|null
    {
        if (empty($row[0]) || empty($row[1])) {
            return null;
        }
        // handle kode dan nama 
        $prodi = Prodi::where('kode_prodi', $row[1])->where('nama_prodi', $row[2])->first();
        if ($prodi){
            return null;
        }
        return Prodi::create([
            'kode_prodi' => $row[1],
            'nama_prodi' => $row[2],
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
}
