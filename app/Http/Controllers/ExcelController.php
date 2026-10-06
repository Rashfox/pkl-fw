<?php

namespace App\Http\Controllers;
use App\Exports\DosenExport;
use App\Exports\MakulExport;
use App\Exports\PerakExport;
use App\Exports\ProdiExport;
use App\Imports\DosenImport;
use App\Imports\KelasMakulImport;
use App\Imports\MakulImport;
use App\Imports\ProdiImport;
use Illuminate\Http\Request;
use App\Exports\MahasiswaExport;
use App\Imports\MahasiswaImport;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function mahasiswaExpor() 
    {
        return Excel::download(new MahasiswaExport(), 'mahasiswa '.date('d M Y').'.xlsx');
    }
    public function mahasiswaImpor(Request $request) 
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        $role = 'm';
        $pin = sha1('123456');

        Excel::import(new MahasiswaImport(), $request->file('file_excel'));
        Excel::import(new UserImport($role, $pin), $request->file('file_excel'));

        return back()->with('sukses', 'Data berhasil diimpor!');
    }
    public function dosenExpor() 
    {
        return Excel::download(new DosenExport(), 'dosen '.date('d M Y').'.xlsx');
    }
    public function dosenImpor(Request $request) 
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        $role = 'd';
        $pin = sha1('696969');

        Excel::import(new DosenImport(), $request->file('file_excel'));
        Excel::import(new UserImport($role, $pin), $request->file('file_excel'));

        return back()->with('sukses', 'Data berhasil diimpor!');
    }
    public function prodiExpor() 
    {
        return Excel::download(new ProdiExport(), 'prodi '.date('d M Y').'.xlsx');
    }
    
    public function prodiImpor(Request $request) 
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new ProdiImport(), $request->file('file_excel'));

        return back()->with('sukses', 'Data berhasil diimpor!');
    }
    
    public function perakExpor() 
    {
        return Excel::download(new PerakExport(), 'perak '.date('d M Y').'.xlsx');
    }
    public function makulExpor() 
    {
        return Excel::download(new MakulExport(), 'makul '.date('d M Y').'.xlsx');
    }
    
    public function makulImpor(Request $request) 
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new MakulImport(), $request->file('file_excel'));

        return back()->with('sukses', 'Data berhasil diimpor!');
    }
    public function kelasmakulImpor(Request $request) 
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new KelasMakulImport(), $request->file('file_excel'));

        return back()->with('sukses', 'Data berhasil diimpor!');
    }
}