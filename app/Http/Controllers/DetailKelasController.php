<?php
namespace App\Http\Controllers;
use App\Models\DetailKelas;
use App\Models\KelasMakul;
use App\Models\Mahasiswa;
use App\Models\Presensi;
use Illuminate\Http\Request;

class DetailKelasController extends Controller {
    public function dataDetailKelas($id){
        $kelas = KelasMakul::with(['akademik', 'makul', 'dosen', 'prodi'])->where('id', $id)->first();
        $mahasiswa = Mahasiswa::get();
        $detail = DetailKelas::with('mahasiswa')->where('id_kelas', $id)->get();
        $jml_mhs=DetailKelas::where('id_kelas', $id)->count('nim');
        $hal= 'kelas';
        if (session('peran') == 'd'){
            $view = 'dosen_data_kelas_makul.detail';
        } else if (session('peran') == 'a'){
            $view = 'admin_data_kelas_makul.detail';
        }
        return view($view, ['kelas'=>$kelas, 'mahasiswa'=>$mahasiswa, 'detail'=>$detail, 'jmlh'=>$jml_mhs,'hal'=>$hal]);
    }

    public function simpanDetail(Request $request){
        $cek = DetailKelas::where('nim', $request->nim)->where('id_kelas', $request->id_kelas)->first();
        if ($cek){
            return redirect()->route('detail.kelas',['id' => $request->id_kelas])->with('error', 'Mahasiswa sudah ada!');
        }
        DetailKelas::insert([
            'id_kelas'=>$request->id_kelas,
            'nim'=>$request->nim,
        ]);
        return redirect()->route('detail.kelas',['id' => $request->id_kelas])->with('sukses', 'Detail kelas berhasil ditambahkan!');
    }
    public function hapusDetail($id){
        $detail = DetailKelas::where('id',$id)->first();
        DetailKelas::where('id', $id)->delete();
        return redirect()->route('detail.kelas',['id' => $detail->id_kelas])->with('sukses', 'Mahasiswa Berhasil dihapus');
    }
}