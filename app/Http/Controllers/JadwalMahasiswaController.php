<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalMahasiswaController extends Controller
{
    public function index()
    {
        return view('mahasiswa.jadwal.index');
    }


    public function data (Request $request)
    {
        $query = Jadwal::hariIni()->kelas()->get();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('matakuliah',function($query) {
                return $query->matakuliah->name;
            })
            ->addColumn('dosen',function($query) {
                return $query->dosen->name;
            })
            ->addColumn('kelas',function($query) {
                return $query->kelas->name;
            })
            ->addColumn('ruang',function($query) {
                return $query->ruang->name;
            })

            ->escapeColumns([])
            ->make(true);
    }
}
