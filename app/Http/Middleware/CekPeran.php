<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekPeran
{
    public function handle(Request $request, Closure $next, ...$perans)
    {
        // 1. Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Ambil peran user saat ini
        $userPeran = Auth::user()->peran;

        // 3. Jika peran user ada di dalam daftar yang diizinkan route, silakan lewat
        if (in_array($userPeran, $perans)) {
            return $next($request);
        }

        if ($userPeran == 'a') return redirect()->route('home.admin')->with('error', 'Akses ditolak!');
        if ($userPeran == 'd') return redirect()->route('home.dosen')->with('error', 'Akses ditolak!');
        if ($userPeran == 'm') return redirect()->route('home.mahasiswa')->with('error', 'Akses ditolak!');

        return redirect('/')->with('error', 'Akses ditolak!');
    }
}