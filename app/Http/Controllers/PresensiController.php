<?php

namespace App\Http\Controllers;

use App\Models\Pertemuan;
use App\Models\Presensi;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PresensiController extends Controller
{
    public function dataPresensi($id)
    {
        $pertemuan = Pertemuan::with(['kelasMakul','kelasMakul.dosen', 'kelasMakul.makul', 'kelasMakul.prodi'])->where('id_pertemuan', $id)->first();
        $hal = 'kelas';

        $secret_key = env('QR_SECRET_KEY', 'terserah');
        $waktu_expired = time() + 60;
        $signature = hash_hmac('sha256', $id . $waktu_expired, $secret_key);
        
        $isi_qr = $id . '|' . $waktu_expired . '|' . $signature;

        $qr = QrCode::size(200)->errorCorrection('M')->margin(2)->backgroundColor(255,255,255)->color(0,0,0)->generate($isi_qr);
        $qr_image = 'data:image/svg+xml;base64,' . base64_encode($qr);
        if (session('peran') == 'd'){
            $view = 'dosen_data_kelas_makul.presensi';
        } else if (session('peran') == 'a'){
            $view = 'admin_data_kelas_makul.presensi';
        }
        return view($view, ['hal' => $hal, 'pertemuan' => $pertemuan, 'qr' => $qr_image]);
    }
    public function tabelPresensi($id){
        $presensi = Presensi::with('mahasiswa')->where('id_pertemuan', $id)->get();
        return view('admin_data_kelas_makul.elemen.table', ['presensi' => $presensi]);
    }
    public function statusPresensi(Request $request, $id)
    {
        Pertemuan::where('id_pertemuan', $id)->update([
            'status_pertemuan' => $request->status,
        ]);
        return redirect()->back()->with('sukses', 'Status pertemuan berhasil diubah!');
    }
    public function ubahstatusPresensi(Request $request)
    {
        Presensi::where('id_presensi', $request->id_presensi)->update([
            'status_pertemuan' => $request->status_pertemuan,
        ]);
        return redirect()->back()->with('sukses', 'Status presensi berhasil diubah!');
    }
    public function mahasiswaPresensi(){
        $hal = 'presensi';
        return view('home_mahasiswa.presensi', compact('hal'));
    }
    public function mahasiswaPostPresensi(Request $request){
        $qr_data = $request->post('kode_kelas');
        $pecah_qr = explode('|', $qr_data);
        if (count($pecah_qr) !== 3) {
            return  redirect()->back()->with('error','Format QR Code tidak dikenali sistem!');
        }else{
            $id_pertemuan = $pecah_qr[0];
            $waktu_expired = $pecah_qr[1];
            $signature = $pecah_qr[2];

            $expected_signature = hash_hmac('sha256', $id_pertemuan . $waktu_expired, 'terserah');
            if ($signature !== $expected_signature){
                return  redirect()->back()->with('error','QR Code tidak valid!');
            }
            if (time() > $waktu_expired){
                return  redirect()->back()->with('error','Kode QR sudah kadaluarsa!');   
            }
            $pertemuan = Pertemuan::where('id_pertemuan', $id_pertemuan)->where('status_pertemuan', '1')->first();
            if (empty($pertemuan)){
                return  redirect()->back()->with('error','Presensi telah ditutup. anda tidak bisa melakukan presensi lagi!');
            }else {
                $cek_mahasiswa = Presensi::where('id_pertemuan', $id_pertemuan)->where('nim', session('username'))->first();
                if (empty($cek_mahasiswa)){
                    return  redirect()->back()->with('error','Anda bukan bagian dari kelas ini!');   
                }
                $cek_presensi = Presensi::where('id_pertemuan', $id_pertemuan)->where('nim', session('username'))->where('status_pertemuan', 'hadir')->first();
                if (!empty($cek_presensi)){
                    return  redirect()->back()->with('error','Anda sudah melakukan presensi!');   
                }
                Presensi::where('id_pertemuan', $id_pertemuan)->where('nim', session('username'))->update([
                    'status_pertemuan' => 'hadir'
                ]);
                return  redirect()->back()->with('sukses','Presensi berhasil!');   
            }
        }
    }   
}
