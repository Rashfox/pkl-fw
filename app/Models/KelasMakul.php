<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class KelasMakul extends Model{
    protected $table = 'kelas_makul';
    public $timestamps = false;
    public $primaryKey = 'id';
    protected $fillable = ['kode_akd','kode_makul', 'kode_prodi', 'kode_dosen', 'nama_kelas'];

    public function makul(){
        return $this->belongsTo(Makul::class, 'kode_makul', 'kode_makul');
    }
    public function prodi(){
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }
    public function akademik(){
        return $this->belongsTo(Akademik::class, 'kode_akd', 'kode_akd');
    }
    public function dosen(){
        return $this->belongsTo(Dosen::class, 'kode_dosen', 'nik');
    }
    public function detailKelas(){
        return $this->hasOne(DetailKelas::class, 'id_kelas', 'id');
    }
    public function pertemuan(){
        return $this->hasMany(Pertemuan::class, 'kode_kelas', 'id');
    }
    public static function getKelas()
    {
        return self::from('kelas_makul as km')
            ->select(
                'km.*', 
                'm.nama_makul', 
                'p.nama_prodi', 
                'a.*', 
                'd.nama as nama_dosen'
            )
            ->leftJoin('prodi as p', 'km.kode_prodi', '=', 'p.kode_prodi')
            ->leftJoin('dosen as d', 'km.kode_dosen', '=', 'd.nik')
            ->leftJoin('makul as m', 'km.kode_makul', '=', 'm.kode_makul')
            ->leftJoin('akademik as a', 'km.kode_akd', '=', 'a.kode_akd')
            ->orderBy('d.nama', 'asc')
            ->orderBy('km.nama_kelas', 'asc')
            ->get();
    }
    public static function getKelasDosen($nik)
    {
        return self::from('kelas_makul as km')
            ->select(
                'km.*', 
                'm.nama_makul', 
                'p.nama_prodi', 
                'a.*', 
                'd.nama as nama_dosen'
            )
            ->leftJoin('prodi as p', 'km.kode_prodi', '=', 'p.kode_prodi')
            ->leftJoin('dosen as d', 'km.kode_dosen', '=', 'd.nik')
            ->leftJoin('makul as m', 'km.kode_makul', '=', 'm.kode_makul')
            ->leftJoin('akademik as a', 'km.kode_akd', '=', 'a.kode_akd')
            ->where('km.kode_dosen', $nik)
            ->orderBy('d.nama', 'asc')
            ->orderBy('km.nama_kelas', 'asc')
            ->get();
    }
    
    public static function getKelasByAkd($kode)
    {
        return self::from('kelas_makul as km')
            ->select(
                'km.*', 
                'm.nama_makul', 
                'p.nama_prodi', 
                'a.*', 
                'd.nama as nama_dosen'
            )
            ->leftJoin('prodi as p', 'km.kode_prodi', '=', 'p.kode_prodi')
            ->leftJoin('dosen as d', 'km.kode_dosen', '=', 'd.nik')
            ->leftJoin('makul as m', 'km.kode_makul', '=', 'm.kode_makul')
            ->leftJoin('akademik as a', 'km.kode_akd', '=', 'a.kode_akd')
            ->where('km.kode_akd', $kode)
            ->orderBy('d.nama', 'asc')
            ->orderBy('km.nama_kelas', 'asc')
            ->get();
    }
    public static function getKelasDosenByAkd($kode, $nik)
    {
        return self::from('kelas_makul as km')
            ->select(
                'km.*', 
                'm.nama_makul', 
                'p.nama_prodi', 
                'a.*', 
                'd.nama as nama_dosen'
            )
            ->leftJoin('prodi as p', 'km.kode_prodi', '=', 'p.kode_prodi')
            ->leftJoin('dosen as d', 'km.kode_dosen', '=', 'd.nik')
            ->leftJoin('makul as m', 'km.kode_makul', '=', 'm.kode_makul')
            ->leftJoin('akademik as a', 'km.kode_akd', '=', 'a.kode_akd')
            ->where('km.kode_akd', $kode)
            ->where('km.kode_dosen', $nik)
            ->orderBy('d.nama', 'asc')
            ->orderBy('km.nama_kelas', 'asc')
            ->get();
    }
    public static function getKelasByID($id)
    {
        return self::from('kelas_makul as km')
            ->select(
                'km.*', 
                'm.nama_makul', 
                'p.nama_prodi', 
                'a.*', 
                'd.nama as nama_dosen'
            )
            ->leftJoin('prodi as p', 'km.kode_prodi', '=', 'p.kode_prodi')
            ->leftJoin('dosen as d', 'km.kode_dosen', '=', 'd.nik')
            ->leftJoin('makul as m', 'km.kode_makul', '=', 'm.kode_makul')
            ->leftJoin('akademik as a', 'km.kode_akd', '=', 'a.kode_akd')
            ->where('km.id',$id)
            ->orderBy('d.nama', 'asc')
            ->orderBy('km.nama_kelas', 'asc')
            ->first();
    }
}