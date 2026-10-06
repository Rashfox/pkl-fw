<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mahasiswa extends Model{
    protected $table = 'mahasiswa';
    public $timestamps = false;
    protected $primaryKey = 'nim';
    protected $keyType = 'string';
    protected $fillable = ['nim', 'nama', 'kontak', 'email', 'kelamin'];

    public function detailKelas(){
        return $this->hasMany(DetailKelas::class, 'nim');
    }
    public static function sk($nim) {
        return self::from('kelas_makul as km')
        ->join('prodi as p', 'km.kode_prodi', '=', 'p.kode_prodi')
        ->join('detail_kelas as dk', 'km.id', '=', 'dk.id_kelas')
        ->join('mahasiswa as m', 'dk.nim', '=', 'm.nim')
        ->join('akademik as a', 'km.kode_akd', '=', 'a.kode_akd')
        ->where('dk.nim', $nim)
        ->where('a.is_active', 1)
        ->first();
    }
    
}