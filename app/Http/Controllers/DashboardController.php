<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            $userId = Auth::id();

            $mahasiswa = Mahasiswa::where('user_id', $userId)->first();

            return view('mahasiswa.dashboard.index', compact('mahasiswa'));
        }
    }



}
