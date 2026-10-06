<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Akademik extends Model{
    protected $table = 'akademik';
    public $timestamps = false;
    protected $primaryKey = 'kode_akd';
    protected $keyType = 'string';
    protected $fillable = ['semester', 'tahun', 'is_active'];
}