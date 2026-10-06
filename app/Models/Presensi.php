<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presensi extends Model{
    protected $table = 'presensi';
    public $timestamps = false;
    protected $primaryKey = 'id_presensi';
    protected $fillable = ['id_pertemuan', 'nim', 'status_pertemuan'];

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }
    public function pertemuan(){
        return $this->belongsTo(Pertemuan::class, 'id_pertemuan');
    }
    public static function getPresensi($id){
        return self::from('presensi as p')
        ->select(
            'p.*',
            'm.nama'
        )
        ->leftJoin('mahasiswa as m', 'p.nim', '=', 'm.nim')
        ->where('p.id_pertemuan', $id)
        ->orderBy('m.nama')
        ->get();
    }
}