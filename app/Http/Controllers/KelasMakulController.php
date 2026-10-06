<?php
namespace App\Http\Controllers;
use App\Models\Akademik;
use App\Models\Dosen;
use App\Models\KelasMakul;
use App\Models\Makul;
use App\Models\Prodi;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class KelasMakulController extends Controller{
    public function dataKelas(Request $request)
    {
        $kode_akd = '';
        if (session('peran') == 'd'){
            if (!empty($request->kode_akd)){
                $kode_akd = $request->kode_akd;  
                $kelas = KelasMakul::with(['akademik', 'makul', 'dosen' => function($query) {
                    $query->where('nik', session('username'));
                }, 'prodi'])->where('kode_akd', $kode_akd)->get();
            }else{
                $kelas = KelasMakul::with(['akademik', 'makul', 'dosen' => function ($query) {
                    $query->where('nik', session('username'));
                },'prodi'])->get();
            }
        } elseif (session('peran') == 'a'){
            if (!empty($request->kode_akd)){
                $kode_akd = $request->kode_akd;  
                $kelas = KelasMakul::with(['akademik', 'makul', 'dosen', 'prodi'])->where('kode_akd', $kode_akd)->get();
            }else{
                $kelas = KelasMakul::with(['akademik', 'makul', 'dosen', 'prodi'])->get();
            }
        }
        $perak = Akademik::get();
        $makul = Makul::get();
        $prodi = Prodi::get();
        $dosen = Dosen::get();
        $hal = 'kelas';
        return view('admin_data_kelas_makul.index', [
            'hal' => $hal, 
            'kelas' => $kelas, 
            'perak' => $perak, 
            'makul' => $makul, 
            'prodi' => $prodi, 
            'dosen' => $dosen, 
            'kode_akd' => $kode_akd
            ]);
    }
    public function editKelas($id)
    {
        $kelas = KelasMakul::where('id', $id)->first();
        $perak = Akademik::get();
        $makul = Makul::get();
        $prodi = Prodi::get();
        $dosen = Dosen::get();
        $hal = 'kelas';
        return view('admin_data_kelas_makul.edit', [
            'hal' => $hal, 
            'kelas' => $kelas, 
            'perak' => $perak, 
            'makul' => $makul, 
            'prodi' => $prodi, 
            'dosen' => $dosen, 
            ]);
    }
    public function simpanKelas(Request $request){
        $kode_akd = $request->kode_akd;
        $kode_makul = $request->kode_makul;
        $kode_prodi = $request->kode_prodi;
        $kode_dosen = $request->kode_dosen;
        $nama_kelas = $request->nama_kelas;
        $cek = KelasMakul::where('kode_akd', $kode_akd)
                ->where('kode_makul', $kode_makul)
                ->where('kode_prodi', $kode_prodi)
                ->where('kode_dosen', $kode_dosen)
                ->where('nama_kelas', $nama_kelas)
                ->first();
        if (empty($cek)){
            KelasMakul::create([
                'kode_akd'   => $kode_akd,
                'kode_makul' => $kode_makul,
                'kode_prodi' => $kode_prodi,
                'kode_dosen' => $kode_dosen,
                'nama_kelas' => $nama_kelas,
            ]);
            return redirect()->route('kelas.admin')->with('sukses', 'Data Mata Kuliah berhasil ditambahkan!');
        }
        return redirect()->route('kelas.admin')->with('error', 'Data Mata Kuliah sudah ada!');
    }
    public function updateKelas(Request $request){
        $kode_akd = $request->kode_akd;
        $kode_makul = $request->kode_makul;
        $kode_prodi = $request->kode_prodi;
        $kode_dosen = $request->kode_dosen;
        $nama_kelas = $request->nama_kelas;
        $cek = KelasMakul::where('kode_akd', $kode_akd)
                ->where('kode_makul', $kode_makul)
                ->where('kode_prodi', $kode_prodi)
                ->where('kode_dosen', $kode_dosen)
                ->where('nama_kelas', $nama_kelas)
                ->first();
        if (empty($cek)){
            KelasMakul::where('kode_makul', $kode_makul)->update([
                'nama_kelas' => $request->nama_kelas,
                'jml_sks' => $request->jml_sks,
                'jml_cpmk' => $request->jml_cpmk,
            ]);
            return redirect()->route('kelas.admin')->with('sukses', 'Data Mata Kuliah berhasil diubah!');
        }
    }
    public function persenKontrak(Request $request){
        KelasMakul::where('id', $request->kode_kelas)->update([
            'persen_hdr' => $request->persen_hdr
        ]);
        return redirect()->back()->with('sukses', 'Presentase Kontrak berhasi diubah!');
    }
    public function hapusKelas($id){
        KelasMakul::where('id', $id)->delete();
        return redirect()->route('kelas.admin')->with('sukses', 'Data Mata Kuliah berhasil dihapus!');
    }
}