<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model{
    protected $table = 'pertemuan';
    protected $primaryKey = 'id_pertemuan';
    public $timestamps = false;
    protected $fillable = ['id_pertemuan', 'kode_kelas','tgl_pertemuan', 'judul_pertemuan','pertemuan_ke', 'status_pertemuan'];

    public function kelasMakul(){
        return $this->belongsTo(KelasMakul::class, 'kode_kelas', 'id');
    }
    public function presensi(){
        return $this->hasMany(Presensi::class, 'id_pertemuan');
    }
    
    public static function getPertemuan($id){
        return self::from('pertemuan as p')
        ->select(
            'd.*',
            'm.nama_makul',
            'km.nama_kelas',
            'pr.nama_prodi',
            'p.*',
        )
        ->leftJoin('kelas_makul as km', 'p.kode_kelas', '=','km.id')
        ->leftJoin('dosen as d', 'km.kode_dosen', '=','d.nik')
        ->leftJoin('makul as m', 'km.kode_makul', '=','m.kode_makul')
        ->leftJoin('prodi as pr', 'km.kode_prodi', '=','pr.kode_prodi')
        ->where('p.id_pertemuan', $id)
        ->first();
    }
}