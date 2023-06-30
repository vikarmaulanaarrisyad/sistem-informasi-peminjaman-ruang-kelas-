<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pengembalian.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function data(Request $request)
    {
        $query = Pengembalian::orderBy('id', 'DESC');
        return datatables($query)
            ->addIndexColumn()
            ->addColumn('nim', function ($query) {
                return $query->peminjaman->mahasiswa->nim;
            })
            ->addColumn('nama_mahasiswa', function ($query) {
                return $query->peminjaman->mahasiswa->name;
            })
            ->addColumn('ruang', function ($query) {
                return $query->peminjaman->jadwal->ruang->name;
            })
            ->addColumn('pengembalian', function ($query) {
                return $query->created_at;
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        $peminjaman = Peminjaman::with('jadwal')->where('mahasiswa_id', $mahasiswa->id)->get();

        return view('admin.pengembalian.validasi', compact('mahasiswa', 'peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function validasi(Request $request)
    {
        $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Data tidak ditemukan dalam sistem'], 422);
        }

        //cek apakah mahasiswa memiliki peminjaman ruangan
        $peminjaman = Peminjaman::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'pinjam')->first();

        if ($peminjaman == NULL) {
            return response()->json(['message' => 'Tidak ada peminjaman ruangan dengan NIM ' . $mahasiswa->nim . ' ',], 400);
        }

        if (!$mahasiswa) {
            return response()->json(['message' => 'Data tidak ditemukan dalam sistem'], 422);
        }

        $peminjaman->update(['status' => 'kembali']);

        $pengembalian = new Pengembalian();
        $pengembalian->peminjaman_id = $peminjaman->id;
        $pengembalian->save();

        return response()->json(['message' => 'Data ditemukan dalam sistem'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengembalian $pengembalian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengembalian $pengembalian)
    {
        //
    }
}
