<?php
namespace App\Http\Controllers;
use App\Models\Prodi;
use Illuminate\Http\Request;
class ProdiController extends Controller{
    public function dataProdi()
    {
        $prodi = Prodi::get();
        $hal = 'data_prodi';
        return view('admin_data_prodi.index', ['hal' => $hal, 'prodi' => $prodi]);
    }
    public function editProdi($kode)
    {
        $prodi = Prodi::where('kode_prodi', $kode)->first();
        $hal = 'data_prodi';
        return view('admin_data_prodi.edit', ['hal' => $hal, 'prodi' => $prodi]);
    }
    public function simpanProdi(Request $request){
        $kode_prodi = $request->kode_prodi;
        $cek = Prodi::where('kode_prodi', $kode_prodi)->first();
        if (empty($cek)){
            Prodi::insert([
                'kode_prodi' => $kode_prodi,
                'nama_prodi' => $request->nama_prodi
            ]);
            return redirect()->route('prodi.admin')->with('sukses', 'Data Mata Kuliah berhasil ditambahkan!');
        }
        return redirect()->route('prodi.admin')->with('error', 'Data Mata Kuliah sudah ada!');
    }
    public function updateProdi(Request $request){
        $kode_prodi = $request->kode_prodi;
        Prodi::where('kode_prodi', $kode_prodi)->update([
            'nama_prodi' => $request->nama_prodi
        ]);
        return redirect()->route('prodi.admin')->with('sukses', 'Data Mata Kuliah berhasil diubah!');
    }
    public function hapusProdi($kode){
        $kode_prodi = $kode;
        Prodi::where('kode_prodi', $kode_prodi)->delete();
        return redirect()->route('prodi.admin')->with('sukses', 'Data Mata Kuliah berhasil dihapus!');
    }
    public function resetProdi(){
        Prodi::truncate();
        return redirect()->route('prodi.admin')->with('sukses', 'Data Mata Kuliah berhasil direset!');
    }
}