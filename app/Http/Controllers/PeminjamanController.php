<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use DateTime;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    /**
     * Display a listing of the resource.
     */
    public function data(Request $request)
    {
        $query = Peminjaman::all();

        return datatables($query)
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();
        $jadwal = Jadwal::findOrfail($request->jadwal_id);



        $currentTime = new DateTime();
        $waktuSekarang = $currentTime->format('H:i:s');

        if (!$mahasiswa) {
            return response()->json(['message' => 'Data Mahasiswa tidak ditemukan dalam sistem.'], 422);
        }

        $peminjaman = Peminjaman::where('mahasiswa_id', $mahasiswa->id)->first();

        if($mahasiswa->id == $peminjaman->mahasiswa_id) {
            return response()->json(['message' => 'Mahasiswa sedang dalam proses pinjam ruangan.'], 422);
        }

        if ($jadwal->waktu_mulai < $waktuSekarang) {
            return response()->json(['message' => 'Jadwal matakuliah belum dimulai.'], 422);
        } else if ($jadwal->waktu_mulai > $waktuSekarang) {
            return response()->json(['message' => 'Jadwal matakuliah sudah berakhir.'], 422);
        }

        $data = [
            'mahasiswa_id' => $mahasiswa->id,
            'jadwal_id' => $request->jadwal_id,
        ];

        $peminjaman = Peminjaman::create($data);

        return response()->json(['data' => $peminjaman, 'message' => 'Data berhasil disimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //
    }
}
