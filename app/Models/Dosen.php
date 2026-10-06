<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model{
    protected $table = 'dosen';
    public $timestamps = false;
    protected $primaryKey = 'nik';
    protected $keyType = 'string';
    protected $fillable = ['nik', 'nama', 'kontak', 'email', 'kelamin'];
}