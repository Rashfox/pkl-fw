<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable{
    protected $table = 'user';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = ['username', 'nama', 'id', 'password', 'peran', 'pin','last_update'];
}