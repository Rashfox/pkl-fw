<?php
namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\Pertemuan;
use App\Models\Prodi;
use App\Models\Dosen;
use Carbon\Carbon;

class DashboardController extends Controller{
    public function dashboardAdmin()
    {
        $hal = 'beranda_admin';
        $jml_mhs = Mahasiswa::count('nim');
        $jml_dosen = Dosen::count('nik');
        $jml_prodi = Prodi::count('kode_prodi');
        $presensi_bulan =  Pertemuan::selectRaw('MONTH(tgl_pertemuan) as month')->withCount(['presensi' => function($query){
            $query->where('status_pertemuan', 'hadir');
        }])->whereYear('tgl_pertemuan', date('Y'))
        ->get()->groupBy('month')->map(function($row) {
            return $row->sum('presensi_count');
        });
        $data_hadir = [];
        for ($i = 1; $i <= 12; $i++) {
            $data_hadir[] = isset($presensi_bulan[$i]) ? $presensi_bulan[$i] : 0;
        }
        // dd($data_hadir);
        return view('home_admin.index', compact('hal', 'jml_dosen', 'jml_mhs', 'jml_prodi', 'data_hadir'));
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