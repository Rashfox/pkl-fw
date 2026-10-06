<?php
namespace App\Http\Controllers;
use App\Models\DetailKelas;
use App\Models\KelasMakul;
use App\Models\Pertemuan;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PertemuanController extends Controller {
    public function dataPertemuan($kode){
       $pertemuan = Pertemuan::where('kode_kelas', $kode)->get(); 
       $kelas = KelasMakul::with(['akademik', 'makul', 'dosen', 'prodi'])->where('id', $kode)->first();
       $hal = 'kelas';
       if (session('peran') == 'd'){
        $view = 'dosen_data_kelas_makul.pertemuan';
       } else if (session('peran') == 'a'){
        $view = 'admin_data_kelas_makul.pertemuan';
       }
       return view($view, ['hal' => $hal, 'pertemuan' => $pertemuan, 'kelas' => $kelas]);
    }
    public function simpanPertemuan(Request $request) {
        $pertemuan = Pertemuan::where('kode_kelas', $request->kode_kelas)->max('pertemuan_ke');
        $simpan = Pertemuan::createOrFirst([
            'kode_kelas' => $request->kode_kelas,
            'tgl_pertemuan' => Carbon::now(),
            'judul_pertemuan' => $request->judul_pertemuan,
            'pertemuan_ke' => (empty($pertemuan))?1:$pertemuan+1,
            'status_pertemuan' => '1'
        ]);
        $mhs = DetailKelas::where('id_kelas', $request->kode_kelas)->get();
        foreach ($mhs as $m){
            Presensi::insert([
                'id_pertemuan' => $simpan->id_pertemuan,
                'nim' => $m->nim
            ]);
        }
        if ($simpan){
            return redirect()->route('data.presensi', ['id' => $simpan->id_pertemuan]);
        }
        return redirect()->back()->with('error', 'Data Pertemuan sudah ada!');
    }
    public function hapusPertemuan($id){
        Pertemuan::where('id_pertemuan', $id)->delete();
        return redirect()->back()->with('sukses', 'Pertemuan berhasil dihapus!');
    }
}