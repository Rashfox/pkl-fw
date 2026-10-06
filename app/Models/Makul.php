<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Makul extends Model{
    protected $table = 'makul';
    public $timestamps = false;
    protected $primaryKey = 'kode_makul';
    protected $keyType = 'string';
    protected $fillable = ['kode_makul', 'nama_makul', 'jml_sks', 'jml_cpmk'];
}