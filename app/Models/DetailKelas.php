<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DetailKelas extends Model{
    protected $table = 'detail_kelas';
    public $timestamps = false;
    protected $fillable = ['id_kelas', 'nim'];

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }
    public function kelasMakul(){
        return $this->belongsTo(KelasMakul::class, 'id_kelas', 'id');
    }
    public static function getDetail($id){
        return self::from('detail_kelas as dk')->select(
            'dk.*',
            'm.*'
            )
            ->leftJoin('mahasiswa as m', 'dk.nim', '=', 'm.nim')
            ->where('dk.id_kelas',$id)
            ->orderBy('m.nama')
            ->get();
    }
}