<?php
namespace App\Http\Controllers;
use App\Models\Makul;
use Illuminate\Http\Request;
class MakulController extends Controller{
    public function dataMakul()
    {
        $makul = Makul::get();
        $hal = 'mata_kuliah';
        return view('admin_data_makul.index', ['hal' => $hal, 'makul' => $makul]);
    }
    public function editMakul($kode)
    {
        $makul = Makul::where('kode_makul', $kode)->first();
        $hal = 'mata_kuliah';
        return view('admin_data_makul.edit', ['hal' => $hal, 'makul' => $makul]);
    }
    public function simpanMakul(Request $request){
        $kode_makul = $request->kode_makul;
        $cek = Makul::where('kode_makul', $kode_makul)->first();
        if (empty($cek)){
            Makul::insert([
                'kode_makul' => $kode_makul,
                'nama_makul' => $request->nama_makul,
                'jml_sks' => $request->jml_sks,
                'jml_cpmk' => $request->jml_cpmk,
            ]);
            return redirect()->route('makul.admin')->with('sukses', 'Data Mata Kuliah berhasil ditambahkan!');
        }
        return redirect()->route('makul.admin')->with('error', 'Data Mata Kuliah sudah ada!');
    }
    public function updateMakul(Request $request){
        $kode_makul = $request->kode_makul;
        Makul::where('kode_makul', $kode_makul)->update([
            'nama_makul' => $request->nama_makul,
            'jml_sks' => $request->jml_sks,
            'jml_cpmk' => $request->jml_cpmk,
        ]);
        return redirect()->route('makul.admin')->with('sukses', 'Data Mata Kuliah berhasil diubah!');
    }
    public function hapusMakul($kode){
        $kode_makul = $kode;
        Makul::where('kode_makul', $kode_makul)->delete();
        return redirect()->route('makul.admin')->with('sukses', 'Data Mata Kuliah berhasil dihapus!');
    }
    public function resetMakul(){
        Makul::truncate();
        return redirect()->route('makul.admin')->with('sukses', 'Data Mata Kuliah berhasil direset!');
    }
}