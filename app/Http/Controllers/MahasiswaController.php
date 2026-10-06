<?php
namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller{
    public function dataMahasiswa()
    {
        $mahasiswa = Mahasiswa::get();
        $hal = 'data_mahasiswa';
        return view('admin_data_mahasiswa.index', ['hal' => $hal, 'mahasiswa' => $mahasiswa]);
    }
    public function editMahasiswa($nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $hal = 'data_mahasiswa';
        return view('admin_data_mahasiswa.edit', ['hal' => $hal, 'mahasiswa' => $mahasiswa]);
    }
    public function simpanMahasiswa(Request $request){
        $simpan = Mahasiswa::insert([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'email' => $request->email,
            'kontak' => $request->kontak,
            'kelamin' => $request->kelamin,
        ]);
        $simpanuser = User::insert([
            'username' => $request->nim,
            'password' => sha1($request->nim),
            'nama' => $request->nama,
            'peran' => 'm',
            'pin' => sha1('123456'),
        ]);
        if ($simpan && $simpanuser){
            return redirect()->route('data.mahasiswa')->with('sukses', 'Data Mahasiswa berhasil disimpan');
        }
        return redirect()->route('data.mahasiswa')->with('error', 'Data gagal disimpan');
    }
    public function fotoMahasiswa(Request $request){
        $foto = $request->file('foto');
        $destination= public_path('asset_web/img/mhs');
        $file_name = 'foto'.$request->nim.'.'.$foto->getClientOriginalExtension();
        $move = $foto->move($destination, $file_name);
        $updatefoto = Mahasiswa::where('nim', $request->nim)->update([
            'img' => '../asset_web/img/mhs/'.$file_name
        ]);
        if ($move || $updatefoto){
            return redirect()->route('data.mahasiswa')->with('sukses', 'Data Mahasiswa berhasil disimpan');
        }
        return redirect()->route('data.mahasiswa')->with('error', 'Data gagal disimpan');
    }
    public function updateMahasiswa(Request $request){
        $nim = $request->nim;
        
        $update = Mahasiswa::where('nim', $nim)->update([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'email' => $request->email,
            'kelamin' => $request->kelamin,
        ]);
        if ($update){
            return redirect()->route('data.mahasiswa')->with('sukses', 'Data Mahasiswa berhasil diupdate');
        }
        return redirect()->route('data.mahasiswa')->with('error', 'Data gagal diupdate');
    }
    public function hapusMahasiswa($nim){
        $delete = Mahasiswa::where('nim', $nim)->delete();
        if ($delete){
            return redirect()->route('data.mahasiswa')->with('sukses', 'Data mahasiswa berhasil dihapus');
        }
        return redirect()->route('data.mahasiswa')->with('error', 'Data mahasiswa gagal dihapus');
    }
}