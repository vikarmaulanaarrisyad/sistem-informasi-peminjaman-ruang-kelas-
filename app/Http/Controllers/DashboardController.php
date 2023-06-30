<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\Ruang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();


        if ($user->hasRole('admin')) {

            $totalMahasiswa = Mahasiswa::count();
            $totalDosen = Dosen::count();
            $totalKelas = Kelas::count();
            $totalRuang = Ruang::count();

            return view('admin.dashboard.index', compact([
                'totalMahasiswa',
                'totalDosen',
                'totalKelas',
                'totalRuang',
            ]));
        } else {
            return view('karyawan.dashboard.index');
        }
    }
}
