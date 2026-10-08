<?php
namespace App\Http\Controllers;
use App\Models\KelasMakul;
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
        // print_r($data_hadir);
        // exit;
        return view('home_admin.index', compact('hal', 'jml_dosen', 'jml_mhs', 'jml_prodi', 'data_hadir'));
    }
    public function dashboardDosen()
    {
        $hal = 'beranda_dosen';
        $jml_mhs = KelasMakul::whereHas('akademik', function($akd){
            $akd->where('tahun', date('Y'));
        })->where('kode_dosen', session('username'))->withCount('detailKelas')
        ->get()->pluck('detail_kelas_count', 'id');
        $kelas = KelasMakul::whereIn('id', $jml_mhs->keys())->get();
        // dd($kelas);
        $total_kelas = KelasMakul::whereHas('akademik', function($akd){
            $akd->where('tahun', date('Y'));
        })->where('kode_dosen', session('username'))->count();
        $pertemuan = KelasMakul::whereHas('pertemuan', function($query){
            $query->whereDate('tgl_pertemuan', date('Y-m-d'));
        })
        ->where('kode_dosen', session('username'))
        ->withCount(['pertemuan' => function($query){
            $query->whereDate('tgl_pertemuan', date('Y-m-d'));
        }])->get();
        // dd($total_pertemuan);
        $data_kelas= [];
        $data_jumlah=[];
        foreach ($kelas as $k){
            $data_kelas[]= '['.$k->nama_kelas.'] '.$k->kode_makul;
            $data_jumlah[] = $jml_mhs[$k->id]??0;
        }
        foreach ($pertemuan as $kelas){
            $total_pertemuan = $kelas->pertemuan_count;
        }
        return view('home_dosen.index', compact('hal', 'data_kelas', 'data_jumlah', 'total_kelas', 'total_pertemuan'));
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