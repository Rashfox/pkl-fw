<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model{
    protected $table = 'prodi';
    public $timestamps = false;
    protected $primaryKey = 'kode_prodi';
    protected $keyType = 'string';
    protected $fillable = ['kode_prodi', 'nama_prodi'];
}