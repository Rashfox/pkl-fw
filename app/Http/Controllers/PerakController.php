<?php
namespace App\Http\Controllers;
use App\Models\Akademik;
use Illuminate\Http\Request;
class PerakController extends Controller{
    public function dataPerak()
    {
        $perak = Akademik::get();
        $hal = 'periode_akademik';
        return view('admin_data_perak.index', ['hal' => $hal, 'perak' => $perak]);
    }
    public function editPerak($kode)
    {
        $perak = Akademik::where('kode_akd', $kode)->first();
        $hal = 'periode_akademik';
        return view('admin_data_perak.edit', ['hal' => $hal, 'perak' => $perak]);
    }
    public function simpanPerak(Request $request){
        $kode_akd = $request->kode_akd;
        $cek = Akademik::where('kode_akd', $kode_akd)->first();
        if (empty($cek)){
            Akademik::insert([
                'kode_akd' => $kode_akd,
                'semester' => $request->semester,
                'tahun' => $request->tahun,
                'is_active' => $request->status,
            ]);
            return redirect()->route('perak.admin')->with('sukses', 'Data Akademik berhasil ditambahkan!');
        }
        return redirect()->route('perak.admin')->with('error', 'Data Akademik sudah ada!');
    }
    public function updatePerak(Request $request){
        $kode_akd = $request->kode_akd;
        Akademik::where('kode_akd', $kode_akd)->update([
            'kode_akd' => $kode_akd,
            'semester' => $request->semester,
            'tahun' => $request->tahun,
            'is_active' => $request->status,
        ]);
        return redirect()->route('perak.admin')->with('sukses', 'Data Akademik berhasil diubah!');
    }
    public function hapusPerak($kode){
        $kode_akd = $kode;
        Akademik::where('kode_akd', $kode_akd)->delete();
        return redirect()->route('perak.admin')->with('sukses', 'Data Akademik berhasil dihapus!');
    }
    public function resetPerak(){
        Akademik::truncate();
        return redirect()->route('perak.admin')->with('sukses', 'Data Akademik berhasil direset!');
    }
}