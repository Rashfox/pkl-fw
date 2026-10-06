<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Dosen;

class DashboardController extends Controller{
    public function dashboardAdmin()
    {
        $hal = 'beranda_admin';
        return view('home_admin.index', compact('hal'));
    }
    public function dashboardDosen()
    {
        $hal = 'beranda_dosen';
        return view('home_dosen.index', compact('hal'));
    }
    public function dashboardMahasiswa()
    {
        $hal = 'beranda_mahasiswa';
        return view('home_mahasiswa.index', compact('hal'));
    }
    public function adminGantiPass(){
        $hal = 'ganti_password';
        return view('admin_ganti_password.index', ['hal'=> $hal]);
    }
    public function dosenGantiPass(){
        $hal = 'ganti_password';
        return view('dosen_ganti_password.index', ['hal'=> $hal]);
    }
    public function mahasiswaGantiPass(){
        $hal = 'ganti_password';
        return view('mahasiswa_ganti_password.index', ['hal'=> $hal]);
    }
}