<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Peminjaman;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataKelas = Kelas::all();
        $dataMatakuliah = Matakuliah::all();
        $dataRuang = Ruang::all();
        $daftarDosen = Dosen::all();

        return view('admin.jadwal.index', compact('dataKelas', 'dataMatakuliah', 'dataRuang', 'daftarDosen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function data(Request $request)
    {


        $query = Jadwal::hariIni()->with('kelas', 'peminjaman');


        return datatables($query)
            ->addIndexColumn()
            ->addColumn('kelas', function ($query) {
                if ($query->kelas_id == null) {
                    return 'Belum ada kelas';
                }
                return $query->kelas->name;
            })
            ->addColumn('matakuliah', function ($query) {
                if ($query->matakuliah_id == null) {
                    return 'Belum ada kelas';
                }
                return $query->matakuliah->name;
            })
            ->addColumn('dosen', function ($query) {
                return $query->dosen->name ?? '';
            })
            ->addColumn('ruang', function ($query) {
                if ($query->ruang_id == null) {
                    return '';
                }
                return $query->ruang->name;
            })
            ->addColumn('aksi', function ($query) {
                if ($query->jadwal_id > 0) {
                    // // Kode yang akan dijalankan jika jadwal_id kosong (NULL)
                    // // Misalnya, tambahkan logika alternatif atau kembalikan respons yang sesuai
                    // return 'Kosong';
                    return '
                    <div class="btn-group">
                        <button onclick="detailForm(`' . route('jadwal.detail', $query->id) . '`)" class="btn btn-sm btn-success"><i class="fas fa-eye"></i> Pinjam</button>
                    </div>
                ';
                } else {
                    foreach ($query->peminjaman as $pinjam) {
                        if ($pinjam->jadwal_id == $query->id && $pinjam->status == "pinjam") {
                            // Kode yang akan dijalankan jika jadwal_id terisi dan kondisi terpenuhi
                            // Misalnya, tambahkan logika tambahan atau kembalikan respons yang sesuai
                            return '
                            <div class="btn-group">
                                <button disabled class="btn btn-sm btn-success"><i class="fas fa-eye"></i> Pinjam</button>
                            </div>
                        ';
                        } else {
                            return '
                            <div class="btn-group">
                                <button onclick="detailForm(`' . route('jadwal.detail', $query->id) . '`)" class="btn btn-sm btn-success"><i class="fas fa-eye"></i> Pinjam</button>
                            </div>
                        ';
                        }
                    }
                    return '
                    <div class="btn-group">
                    <button onclick="detailForm(`' . route('jadwal.detail', $query->id) . '`)" class="btn btn-sm btn-success"><i class="fas fa-eye"></i> Pinjam</button>
                    <button onclick="editForm(`' . route('jadwal.show', $query->id) . '`)" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i> Edit</button>
                    </div>
                ';
                }
            })
            ->rawColumns(['aksi'])
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'dosen_id' => 'required',
            'matakuliah_id' => 'required',
            'kelas_id' => 'required',
            'ruang_id' => 'required',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i',
            'hari' => 'required',
        ];

        $message = [
            'kelas_id.required' => 'Kelas wajib diisi.',
            'matakuliah_id.required' => 'Matakuliah wajib diisi.',
            'dosen_id.required' => 'Dosen wajib diisi.',
            'ruang_id.required' => 'Dosen wajib diisi.',
            'waktu_mulai.required' => 'Waktu mulai wajib diisi.',
            'waktu_selesai.required' => 'Waktu selesai wajib diisi.',
            'hari.required' => 'Hari wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        foreach ($request->hari as $hari) {
            $data = [
                'dosen_id' => $request->dosen_id,
                'kelas_id' => $request->kelas_id,
                'matakuliah_id' => $request->matakuliah_id,
                'ruang_id' => $request->ruang_id,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'hari' => $hari,
            ];

            $result = Jadwal::create($data);
        }

        return response()->json(['data' => $result, 'message' => 'Data berhasil disimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function create()
    {
        $namaHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        $daftarKelas = Kelas::all();
        $daftarMatkul = Matakuliah::all();
        $daftarRuang = Ruang::all();
        $daftarDosen = Dosen::all();

        return view('admin.jadwal.create', compact('namaHari', 'daftarKelas', 'daftarMatkul', 'daftarRuang', 'daftarDosen'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jadwal = Jadwal::with('dosen', 'ruang', 'matakuliah', 'kelas')->findOrfail($id);


        return response()->json(['data' => $jadwal]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detail($id)
    {
        $jadwal = Jadwal::findOrfail($id);

        return response()->json(['data' => $jadwal]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrfail($id);

        $rules = [
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i',
        ];

        $message = [
            'kelas_id.required' => 'Kelas wajib diisi.',
            'matakuliah_id.required' => 'Matakuliah wajib diisi.',
            'dosen_id.required' => 'Dosen wajib diisi.',
            'ruang_id.required' => 'Dosen wajib diisi.',
            'waktu_mulai.required' => 'Waktu mulai wajib diisi.',
            'waktu_selesai.required' => 'Waktu selesai wajib diisi.',
            'hari.required' => 'Hari wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        $data = [
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ];

        $result = $jadwal->update($data);

        return response()->json(['data' => $result, 'message' => 'Data berhasil disimpan.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal $jadwal)
    {
        //
    }

    /**
     * Get Data Matakuliah by Dosen
     */
    public function getDataMatakuliah(Request $request)
    {
        $matakuliahByDosen = Dosen::with('matakuliah')->findOrfail($request->dosen_id);

        return response()->json(['data' => $matakuliahByDosen]);
    }
}
