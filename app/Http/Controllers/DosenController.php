<?php
namespace App\Http\Controllers;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function dataDosen()
    {
        $dosen = Dosen::get();
        $hal = 'data_dosen';
        return view('admin_data_dosen.index', ['hal' => $hal, 'dosen' => $dosen]);
    }
    public function editDosen($nik)
    {
        $dosen = Dosen::where('nik', $nik)->first();
        $hal = 'data_dosen';
        return view('admin_data_dosen.edit', ['hal' => $hal, 'dosen' => $dosen]);
    }
    public function simpanDosen(Request $request){
        $simpan = Dosen::insert([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'email' => $request->email,
            'kontak' => $request->kontak,
            'kelamin' => $request->kelamin,
        ]);
        $simpanuser = User::insert([
            'username' => $request->nik,
            'password' => sha1($request->nik),
            'nama' => $request->nama,
            'peran' => 'm',
            'pin' => sha1('696969')
        ]);
        if ($simpan && $simpanuser){
            return redirect()->route('data.dosen')->with('sukses', 'Data Dosen berhasil disimpan');
        }
        return redirect()->route('data.dosen')->with('error', 'Data gagal disimpan');
    }
    public function fotoDosen(Request $request){
        $foto = $request->file('foto');
        $destination= public_path('asset_web/img/dosen');
        $file_name = 'foto'.$request->nik.'.'.$foto->getClientOriginalExtension();
        $move = $foto->move($destination, $file_name);
        $updatefoto = Dosen::where('nik', $request->nik)->update([
            'img' => '../asset_web/img/dosen/'.$file_name
        ]);
        if ($move || $updatefoto){
            return redirect()->route('data.dosen')->with('sukses', 'Data Dosen berhasil disimpan');
        }
        return redirect()->route('data.dosen')->with('error', 'Data gagal disimpan');
    }
    public function updateDosen(Request $request){
        $nik = $request->nik;
        
        $update = Dosen::where('nik', $nik)->update([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'email' => $request->email,
            'kelamin' => $request->kelamin,
        ]);
        if ($update){
            return redirect()->route('data.dosen')->with('sukses', 'Data Dosen berhasil diupdate');
        }
        return redirect()->route('data.dosen')->with('error', 'Data gagal diupdate');
    }
}