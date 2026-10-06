<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $username = $request->post('username');
        $password = $request->post('password');
        
        $user = User::where('username', $username)->first();
        
        if ($user && sha1($password) === $user->password) { 
            session([
                'pin_user_id' => $user->id,
                'peran' => $user->peran,
            ]);
            if ($user->last_update == null || $user->last_update < now()->subDays(7)) {
                session(['auth_user_id' => $user->id]);
                return redirect()->route('login')->with('showResetPinModal', true);
            }
            return redirect()->route('login')->with('showPinModal', true);
        }

        return back()->with('error', true);
    }

    public function verifyPin(Request $request)
    {
        if (!session()->has('pin_user_id')) {
            return redirect()->route('login')->withErrors([
                'username' => 'Sesi login PIN telah berakhir. Silakan login ulang.',
            ]);
        }

        $request->validate([
            'pin' => ['required', 'numeric'],
        ]);

        $user = User::find(session('pin_user_id'));

        if (!$user) {
            session()->flush();

            return redirect()->route('login')->withErrors([
                'username' => 'Pengguna tidak ditemukan. Silakan login ulang.',
            ]);
        }

        if (sha1($request->post('pin')) === $user->pin) {
            session()->forget('pin_user_id');
            session(['auth_user_id' => $user->id]);

            return redirect()->route('login')->with('showResetPinModal', true);
        }
        session(['pin_attempts' => session('pin_attempts', 0) + 1]);
        $attempts_left = 3 - session('pin_attempts');
        if ($attempts_left <= 0) {
            session()->flush();
            return redirect()->route('login')->withErrors([
                'username' => 'Anda telah gagal memasukkan PIN sebanyak 3 kali. Silakan login ulang.',
            ]);
        }
        return back()->with('showPinModal', true)->withErrors(['pin' => 'PIN yang dimasukkan salah. ada '.$attempts_left.' percobaan tersisa.']);
    }
    public function resetpin(Request $request)
    {
        if (!session()->has('auth_user_id')) {
            return redirect()->route('login');
        }

        $request->validate([
            'new_pin' => ['required', 'numeric'],
            'confirm_pin' => ['required', 'same:new_pin'],
        ]);

        $user = User::find(session('auth_user_id'));

        if (!$user) {
            session()->flush(); // Hapus semua sesi jika user tidak valid
            return redirect()->route('login')->withErrors([
                'username' => 'Pengguna tidak ditemukan. Silakan login ulang.',
            ]); 
        }
        session(['nama' => $user->nama, 'peran' => $user->peran, 'username' => $user->username, 'id' => $user->id]);
        $user->pin = sha1($request->post('new_pin'));
        $user->last_update = now();
        $user->save();

        // Hapus sesi yang tidak diperlukan lagi setelah PIN direset
        session()->forget('showResetPinModal');

        return redirect()->route('dashboard');
    }
    public function dashboard()
    {
        if (!session()->has('auth_user_id')) {
            return redirect()->route('login');
        }
        $user = User::find(session('auth_user_id'));
        
        if (!$user){
            return redirect()->route('login');
        }
        
        Auth::login($user);
        $peran = session('peran');
        if ($peran === 'a') {
            return redirect()->route('home.admin');
        } elseif ($peran === 'm') {
            return redirect()->route('home.mahasiswa');
        } else {
            return redirect()->route('home.dosen');
        }
    }
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->withErrors('Selamat Tinggal');
    }
    
}
