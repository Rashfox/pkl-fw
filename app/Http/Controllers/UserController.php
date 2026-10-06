<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use function Laravel\Prompts\alert;
class UserController extends Controller{
    public function dataUser()
    {
        $users = User::where('peran', 'a')->get();
        $hal = 'data_administrator';
        return view('admin_data_administrator.index', ['hal' => $hal, 'users' => $users]);
    }
    public function simpanUser(Request $request){
        $username = $request->username;
        $nama = $request->nama;
        $peran = $request->peran;
        if ($peran == 'd'){
            $pin = sha1('696969');
        } else if ($peran == 'm'){
            $pin = sha1('123456');
        }else {
            $pin = sha1('654321');
        }
        $ada = User::where('username', $username)->first();
        if (is_null($ada)){
            User::insert([
                'username' => $username,
                'pin' => $pin,
                'peran' => $peran,
                'nama' => $nama,
                'password' => sha1($username),
            ]);
            return redirect()->back()->with('simpan_sukses', true);
        } else {
            return redirect()->back();
        }
    }
    public function editUser($id)
    {
        $user = User::where('id', $id)->first();
        $hal = 'data_administrator';
        return view('admin_data_administrator.edit', ['hal' => $hal, 'user' => $user]);
    }
    public function updateUser(Request $request){
        $id = $request->id;
        $update = User::where('id', $id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
        ]);
        if ($update){
            return redirect()->route('data.user')->with('sukses', 'Data user berhasil diupdate');
        }
        return redirect()->route('data.user')->with('error', 'Data gagal diupdate');
    }
    public function hapusUser($id){
        if ($id != session('auth_user_id')){
            User::where('id',$id)->delete();
            return redirect()->route('data.user')->with('sukses', 'Data user berhasil dihapus');
        }
        return redirect()->route('data.user')->with('error', 'Tidak dapat menghapus user yang sedang login');
    }
    public function gantipassUser(Request $request){
        $username = $request->username; 
        $password_lama = sha1($request->password_lama); 
        $password = sha1($request->password_baru);
        $pin = sha1($request->pin);
        $user = User::select('id','password','pin')->where('username', $username)->first();
        $password_db = $user['password'];
        $pin_db = $user['pin'];
        $id = $user['id'];
        if ($password_lama == $password_db && $pin == $pin_db){
            if ($password != $password_db){
                User::where('id', $id)->update([
                    'password' => $password
                ]);
                return redirect()->back()->with('sukses', 'Password berhasil diubah');
            }else{
                return redirect()->back()->with('error', 'Password tidak boleh sama dengan sebelumnya');
            }
        }else {
            return redirect()->back()->with('error', 'Password atau PIN salah');
        }
    }
}