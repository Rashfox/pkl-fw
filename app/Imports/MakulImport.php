<?php

namespace App\Imports;

use App\Models\Makul;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MakulImport implements ToModel,WithStartRow
{
    public function model(array $row): Model|null
    {
        if (empty($row[1]) || empty($row[2])){
            return null;
        }
        $makul = Makul::where('kode_makul', $row[1])->where('nama_makul', $row[2])->first();
        if ($makul){
            return null;
        }
        return new Makul([
            'kode_makul' => $row[1],
            'nama_makul' => $row[2],
            'jml_sks' => $row[3],
            'jml_cpmk' => $row[4]
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
}
