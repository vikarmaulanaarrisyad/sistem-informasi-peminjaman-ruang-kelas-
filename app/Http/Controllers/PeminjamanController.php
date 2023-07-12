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
        return view('admin.peminjaman.index');
    }
    /**
     * Display a listing of the resource.
     */
    public function data(Request $request)
    {
        $query = Peminjaman::orderBy('created_at', 'DESC');

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('jadwal', function ($query) {
                return $query->jadwal->kelas->name;
            })
            ->addColumn('mahasiswa', function ($query) {
                return $query->mahasiswa->name;
            })
            ->addColumn('mulai', function ($query) {
                return date('d-m-Y H:i:s', strtotime($query->created_at));
            })
            ->addColumn('selesai', function ($query) {
                if ($query->status == 'kembali') {
                    return date('d-m-Y H:i:s', strtotime($query->updated_at));
                }
                return '-';
            })
            ->addColumn('status', function ($query) {
                return '<span class="badge badge-' . $query->statusColor() . '">' . $query->statusText() . '</span>';
            })
            ->addColumn('keterangan_alat', function ($query) {
                foreach ($query->jadwal->ruang->perlengkapan as $perlengkapan) {
                    return $perlengkapan->keterangan ?? '-';
                }
            })
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
        $jadwal = Jadwal::findOrFail($request->jadwal_id);

        $currentTime = new DateTime();
        $waktuSekarang = $currentTime->format('H:i:s');

        if (!$mahasiswa) {
            return response()->json(['message' => 'Data Mahasiswa tidak ditemukan dalam sistem.'], 422);
        }

        if ($mahasiswa->kelas_mahasiswa->isEmpty()) {
            return response()->json(['message' => 'Data Mahasiswa tidak ditemukan dalam kelas.'], 422);
        }

        if (!$mahasiswa->kelas_mahasiswa->where('kelas_id', $jadwal->kelas_id)) {
            return response()->json(['message' => 'Data Mahasiswa tidak berada dalam kelas yang dipinjam.'], 422);
        }

        if ($waktuSekarang < $jadwal->waktu_mulai) {
            return response()->json(['message' => 'Jadwal matakuliah belum dimulai.'], 422);
        }

        if ($waktuSekarang > $jadwal->waktu_selesai) {
            return response()->json(['message' => 'Jadwal matakuliah sudah berakhir.'], 422);
        }

        $peminjaman = Peminjaman::where('mahasiswa_id', $mahasiswa->id)->first();

        if ($peminjaman && $peminjaman->status == "pinjam") {
            return response()->json(['message' => 'Mahasiswa sedang dalam proses pinjam ruangan.'], 422);
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
