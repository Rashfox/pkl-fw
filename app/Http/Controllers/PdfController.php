<?php

namespace App\Http\Controllers;

use App\Models\DetailKelas;
use App\Models\KelasMakul;
use App\Models\Mahasiswa;
use App\Models\Makul;
use App\Models\Pertemuan;
use App\Models\Presensi;
use App\Models\Dosen;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PdfController extends Controller
{
    public function makul(){
        $makul = Makul::all(); 
        $pdf = Pdf::loadView('admin_data_makul.pdf', compact('makul'));
    
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Data_Mata_Kuliah '.date('d M Y').'.pdf');
    }
    public function pertemuan($id){
        $detail = KelasMakul::with(['akademik', 'makul', 'dosen', 'prodi'])->where('id', $id)->first();
        $total_pertemuan = Pertemuan::where('kode_kelas', $id)->count();
        $mahasiswa = DetailKelas::with('mahasiswa')->where('id_kelas', $id)->get()->sortBy('mahasiswa.nama')->values();
        foreach ($mahasiswa as $m){
            if ($m->mahasiswa){
                $total_hadir = Pertemuan::whereHas('presensi', function($p) use ($m){
                    $p->where('nim', $m->mahasiswa->nim)->where('status_pertemuan', 'hadir');
                })->where('kode_kelas', $id)->count();
                
                $persentase_hadir = $total_pertemuan > 0 ? ($total_hadir/$total_pertemuan) * 100 : 0;
                $bobot_hdr = !empty($detail->persen_hdr) ? $detail->persen_hdr : 0;
                $persentase_kontrak = $persentase_hadir * ($bobot_hdr / 100);

                $m->mahasiswa->total_hadir = $total_hadir;
                $m->mahasiswa->persentase_hadir = round($persentase_hadir, 0);
                $m->mahasiswa->persentase_kontrak = round($persentase_kontrak, 0);
            }
        }
        $pdf = Pdf::loadView('admin_data_kelas_makul.allpdf', compact('detail', 'mahasiswa', 'total_pertemuan'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Data_Pertemuan '.date('d M Y').'.pdf');
    }
    public function detailPertemuan($id){
        $detail = KelasMakul::with(['akademik', 'makul', 'dosen', 'prodi'])->where('id', $id)->first();
        $pertemuan = Pertemuan::where('kode_kelas', $id)
        ->orderBy('pertemuan_ke', 'asc')
        ->get();

        $total_pertemuan = $pertemuan->count();
        foreach ($pertemuan as $p){
            $p->data_presensi = Presensi::with('mahasiswa')->where('id_pertemuan',$p->id_pertemuan)->get();
            $p->tgl_format = date('d F Y', strtotime($p->tgl_pertemuan));
        }
        $periode = ($detail->akademik->semester == 'gl')? $detail->akademik->tahun.' - Ganjil': $detail->akademik->tahun.' - Genap';
        $pdf = Pdf::loadView('admin_data_kelas_makul.pdf', compact('detail', 'pertemuan', 'total_pertemuan', 'periode'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream('Data_detail_pertemuan '.date('d M Y').'.pdf');
    }
    public function dosen(){
        $dosen = Dosen::orderBy('nama', 'asc')->get();
        $pdf = Pdf::loadView('admin_data_dosen.pdf', compact('dosen'));
    
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Data_Dosen '.date('d M Y').'.pdf');
    }
    public function mahasiswa(){
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $pdf = Pdf::loadView('admin_data_mahasiswa.pdf', compact('mahasiswa'));
    
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Data_Mahasiswa '.date('d M Y').'.pdf');
    }
    public function skMahasiswa($nim){
        $mahasiswa = Mahasiswa::with(['detailKelas' => function($query){
            $query->whereHas('kelasMakul.akademik', function($a) {
                $a->where('is_active', 1);
            })
            ->with(['kelasMakul' => function($q) {
            $q->with(['makul', 'dosen', 'prodi', 'akademik']);
            }]);
        }])->find($nim);
        foreach ($mahasiswa->detailKelas as $detail){
            $namaProdi = $detail->kelasMakul->prodi->nama_prodi;
            $semester = $detail->kelasMakul->akademik->semester;
            $tahun = $detail->kelasMakul->akademik->tahun;
            
            
            $mahasiswa->namaProdi = $namaProdi;
            $mahasiswa->semester = $semester;
            $mahasiswa->tahun = $tahun;
        }
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data SK tidak ditemukan atau mahasiswa belum masuk kelas aktif!');
        }
        $romawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        
        $blnRomawi = $romawi[date('n')];
        $nomorSurat = "..../SK-MHS/PNC/" . $blnRomawi . "/" . date('Y');
        
        Carbon::setLocale('id');
        $tanggalSurat = Carbon::now()->translatedFormat('d F Y');
        
        $pdf = Pdf::loadView('admin_data_mahasiswa.sk', compact('mahasiswa', 'nomorSurat', 'tanggalSurat'));
        
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('SK_Mahasiswa_' . $nim . '_' . date('d M Y') . '.pdf');
    }
}
