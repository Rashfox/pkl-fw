<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;

use App\Http\Controllers\ExcelController;
use App\Http\Controllers\KelasMakulController;
use App\Http\Controllers\DetailKelasController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MakulController;
use App\Http\Controllers\PerakController;
use App\Http\Controllers\PertemuanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/pin', [AuthController::class, 'verifyPin'])->name('pin.verify');
    Route::post('/resetpin', [AuthController::class, 'resetpin'])->name('resetpin.submit');
});
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/ganti-password-user', [UserController::class, 'gantipassUser'])->name('gantipass.user');
    
    // Admin & Dosen
    Route::middleware('cekperan:a,d')->prefix('kelas-makul')->group(function(){
        // Kelas Makul
        Route::get('/data-kelas', [KelasMakulController::class, 'dataKelas'])->name('kelas.admin');
        Route::post('/data-kelas', [KelasMakulController::class, 'dataKelas'])->name('filterkelas.admin');
        Route::post('/persen-kelas', [KelasMakulController::class, 'persenKontrak'])->name('persen.kelas');

        // Pertemuan
        Route::get('/print-pertemuan/{id}', [PdfController::class, 'pertemuan'])->name('pdf.pertemuan');
        Route::get('/print-detail-pertemuan/{id}', [PdfController::class, 'detailPertemuan'])->name('detail.pdf.pertemuan');
        Route::get('/hapus-pertemuan/{id}', [PertemuanController::class, 'hapusPertemuan'])->name('hapus.pertemuan');

        // Detail Kelas
        Route::get('/data-detail-kelas/{id}', [DetailKelasController::class, 'dataDetailKelas'])->name('detail.kelas');
        
        // Pertemuan
        Route::get('/data-pertemuan/{kode}', [PertemuanController::class, 'dataPertemuan'])->name('data.pertemuan');
        Route::post('/simpan-pertemuan', [PertemuanController::class, 'simpanPertemuan'])->name('simpan.pertemuan');

        // Presensi
        Route::get('/data-presensi/{id}', [PresensiController::class, 'dataPresensi'])->name('data.presensi');
        Route::get('/tabel-presensi/{id}', [PresensiController::class, 'tabelPresensi'])->name('tabel.presensi');
        Route::post('/status-presensi/{id}', [PresensiController::class, 'statusPresensi'])->name('status.presensi');
        Route::post('/ubah-status-presensi', [PresensiController::class, 'ubahstatusPresensi'])->name('ubah.status.presensi');
    });
    // Dosen
    Route::middleware('cekperan:d')->prefix('dosen')->group(function(){
        
        Route::get('/', [DashboardController::class, 'dashboardDosen'])->name('home.dosen');
        Route::get('/data-ganti-password', [DashboardController::class, 'dosenGantiPass'])->name('dosen.gantipass');
    });

    // Mahasiswa
    Route::middleware('cekperan:m')->prefix('mahasiswa')->group(function(){
        Route::get('/', [DashboardController::class, 'dashboardMahasiswa'])->name('home.mahasiswa');
        
        Route::get('/data-ganti-password', [DashboardController::class, 'mahasiswaGantiPass'])->name('mahasiswa.gantipass');

        // Presensi
        Route::get('/presensi', [PresensiController::class, 'mahasiswaPresensi'])->name('presensi.mahasiswa');
        Route::post('/post/presensi', [PresensiController::class, 'mahasiswaPostPresensi'])->name('postPresensi.mahasiswa');
    });

    // Admin
    Route::middleware('cekperan:a')->prefix('admin')->group(function(){
        Route::get('/', [DashboardController::class, 'dashboardAdmin'])->name('home.admin');
        Route::get('/data-mahasiswa', [MahasiswaController::class, 'dataMahasiswa'])->name('data.mahasiswa');
        Route::get('/data-dosen', [DosenController::class, 'dataDosen'])->name('data.dosen');
        
        // Periode Akademik
        Route::post('/simpan-data-perak', [PerakController::class, 'simpanPerak'])->name('simpan.perak');
        Route::post('/update-data-perak', [PerakController::class, 'updatePerak'])->name('update.perak');
        Route::get('/data-perak', [PerakController::class, 'dataPerak'])->name('perak.admin');
        Route::get('/edit-data-perak/{kode}', [PerakController::class, 'editPerak'])->name('edit.perak');
        Route::get('/hapus-data-perak/{kode}', [PerakController::class, 'hapusPerak'])->name('hapus.perak');
        Route::get('/reset-data-perak', [PerakController::class, 'resetPerak'])->name('reset.perak');
        Route::get('/ekspor/perak', [ExcelController::class, 'perakExpor'])->name('expor.perak');
        
        // Kelas Mata Kuliah
        Route::post('/simpan-data-kelas', [KelasMakulController::class, 'simpanKelas'])->name('simpan.kelas');
        Route::get('/edit-data-kelas/{id}', [KelasMakulController::class, 'editKelas'])->name('edit.kelas');
        Route::post('/update-data-kelas', [KelasMakulController::class, 'updateKelas'])->name('update.kelas');
        Route::get('/hapus-data-kelas/{id}', [KelasMakulController::class, 'hapusKelas'])->name('hapus.kelas');
        Route::post('/impor-data-kelas', [ExcelController::class, 'kelasmakulImpor'])->name('impor.kelas');
        
        // Detail Kelas
        Route::post('/simpan-detail-kelas', [DetailKelasController::class, 'simpanDetail'])->name('simpan.detail');
        Route::get('/hapus-detail-kelas/{id}', [DetailKelasController::class, 'hapusDetail'])->name('hapus.detail');
        
        // Prodi
        Route::get('/data-prodi', [ProdiController::class, 'dataProdi'])->name('prodi.admin');
        Route::post('/simpan-data-prodi', [ProdiController::class, 'simpanProdi'])->name('simpan.prodi');
        Route::get('/edit-data-prodi/{kode}', [ProdiController::class, 'editProdi'])->name('edit.prodi');
        Route::post('/update-data-prodi', [ProdiController::class, 'updateProdi'])->name('update.prodi');
        Route::get('/hapus-data-prodi/{kode}', [ProdiController::class, 'hapusProdi'])->name('hapus.prodi');
        Route::get('/reset-data-prodi', [ProdiController::class, 'resetProdi'])->name('reset.prodi');
        Route::get('/ekspor/prodi', [ExcelController::class, 'prodiExpor'])->name('expor.prodi');
        Route::post('/impor/prodi', [ExcelController::class, 'prodiImpor'])->name('impor.prodi');

        // Mata Kuliah
        Route::post('/simpan-data-makul', [MakulController::class, 'simpanMakul'])->name('simpan.makul');
        Route::get('/data-makul', [MakulController::class, 'dataMakul'])->name('makul.admin');
        Route::get('/edit-data-makul/{kode}', [MakulController::class, 'editMakul'])->name('edit.makul');
        Route::post('/update-data-makul', [MakulController::class, 'updateMakul'])->name('update.makul');
        Route::get('/hapus-data-makul/{kode}', [MakulController::class, 'hapusMakul'])->name('hapus.makul');
        Route::get('/reset-data-makul', [MakulController::class, 'dataMakul'])->name('reset.makul');
        Route::get('/ekspor/makul', [ExcelController::class, 'makulExpor'])->name('expor.makul');
        Route::post('/impor/makul', [ExcelController::class, 'makulImpor'])->name('impor.makul');
        Route::get('/ekspor-makul', [PdfController::class, 'makul'])->name('pdf.makul');
        
        // User
        Route::get('/data-ganti-password', [DashboardController::class, 'adminGantiPass'])->name('admin.gantipass');
        Route::get('/data-user', [UserController::class, 'dataUser'])->name('data.user');
        Route::post('/simpan-data-user', [UserController::class, 'simpanUser'])->name('tambah.user');
        Route::get('/edit-data-user/{id}', [UserController::class, 'editUser'])->name('edit.user');
        Route::post('/update-data-user', [UserController::class, 'updateUser'])->name('update.user');
        Route::get('/hapus-data-user/{id}', [UserController::class, 'hapusUser'])->name('hapus.user');
        
        // Dosen
        Route::get('/edit-data-dosen/{nik}', [DosenController::class, 'editDosen'])->name('edit.dosen');
        Route::get('/hapus-data-dosen/{nik}', [DosenController::class, 'hapusDosen'])->name('hapus.dosen');
        Route::post('/simpan-data-dosen', [DosenController::class, 'simpanDosen'])->name('simpan.dosen');
        Route::post('/simpan-foto-dosen', [DosenController::class, 'fotoDosen'])->name('foto.dosen');
        Route::post('/update-data-dosen', [DosenController::class, 'updateDosen'])->name('update.dosen');
        Route::get('/reset-data-dosen', [DosenController::class, 'resetDosen'])->name('reset.dosen');
        Route::get('/ekspor/dosen', [ExcelController::class, 'dosenExpor'])->name('expor.dosen');
        Route::post('/impor/dosen', [ExcelController::class, 'dosenImpor'])->name('impor.dosen');
        Route::get('/pdf/dosen', [PdfController::class, 'dosen'])->name('pdf.dosen');

        // Mahasiswa
        Route::get('/edit-data-mahasiswa/{nim}', [MahasiswaController::class, 'editMahasiswa'])->name('edit.mahasiswa');
        Route::get('/hapus-data-mahasiswa/{nim}', [MahasiswaController::class, 'hapusMahasiswa'])->name('hapus.mahasiswa');
        Route::post('/simpan-foto-mahasiswa', [MahasiswaController::class, 'fotoMahasiswa'])->name('foto.mahasiswa');
        Route::post('/simpan-data-mahasiswa', [MahasiswaController::class, 'simpanMahasiswa'])->name('simpan.mahasiswa');
        Route::post('/update-data-mahasiswa', [MahasiswaController::class, 'updateMahasiswa'])->name('update.mahasiswa');
        Route::get('/reset-data-mahasiswa', [MahasiswaController::class, 'resetMahasiswa'])->name('reset.mahasiswa');
        Route::get('/ekspor/mahasiswa', [ExcelController::class, 'mahasiswaExpor'])->name('expor.mahasiswa');
        Route::post('/impor/mahasiswa', [ExcelController::class, 'mahasiswaImpor'])->name('impor.mahasiswa');
        Route::get('/pdf/mahasiswa', [PdfController::class, 'mahasiswa'])->name('pdf.mahasiswa');
        Route::get('/pdf/sk/{nim}', [PdfController::class, 'skMahasiswa'])->name('sk.mahasiswa');
    });
});

