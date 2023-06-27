<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelas;
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

        return view('admin.jadwal.index', compact('dataKelas', 'dataMatakuliah', 'dataRuang'));
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
                    // Kode yang akan dijalankan jika jadwal_id kosong (NULL)
                    // Misalnya, tambahkan logika alternatif atau kembalikan respons yang sesuai
                    return 'Kosong';
                } else {
                    foreach ($query->peminjaman as $pinjam) {
                        if ($pinjam->jadwal_id == $query->id) {
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
                    </div>
                ';
                }
                // return '
                //     <div class="btn-group">
                //         <button onclick="detailForm(`' . route('jadwal.detail', $query->id) . '`)" class="btn btn-sm btn-success"><i class="fas fa-eye"></i> Pinjam</button>
                //     </div>
                // ';
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
            'kelas_id' => 'required',
            'matakuliah_id' => 'required',
        ];

        $message = [
            'kelas_id.required' => 'Kelas wajib diisi.',
            'matakuliah_id.required' => 'Matakuliah wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        $data = [
            'kelas_id' => $request->kelas_id,
            'matakuliah_id' => $request->matakuliah_id,
            'ruang_id' => $request->ruang_id,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ];

        $result = Jadwal::create($data);

        return response()->json(['data' => $result, 'message' => 'Data berhasil disimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jadwal = Jadwal::findOrfail($id);

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
            'kelas_id' => 'required',
            'matakuliah_id' => 'required',
        ];

        $message = [
            'kelas_id.required' => 'Kelas wajib diisi.',
            'matakuliah_id.required' => 'Matakuliah wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        $data = [
            'kelas_id' => $request->kelas_id,
            'matakuliah_id' => $request->matakuliah_id,
            'ruang_id' => $request->ruang_id,
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
}
