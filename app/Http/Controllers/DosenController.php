<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.dosen.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function data(Request $request)
    {
        $query = Dosen::all();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('foto', function ($query) {
                return '
                    <img src="' . asset('assets/images/not.png') . '" class="thumbnail img-responsive" style="width:40px">
                ';
            })
            ->addColumn('matakuliah', function ($query) {
                return '';
            })
            ->addColumn('aksi', function ($query) {
                return '
                    <div class="btn-group">
                    <button onclick="editForm(`' . route('dosen.show', $query->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                     <button onclick="detailDosenMatkulForm(`' . $query->id . '`)" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i> Matakuliah</button>
                </div>
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];

        $message = [
            'name.required' => 'Nama dosen wajib diisi.'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        $data = [
            'name' => trim($request->name),
            'nomor_hp' => trim($request->nomor_hp) ?? 0,
        ];

        $result = Dosen::create($data);

        return response()->json(['data' => $result, 'message' => 'Data berhasil disimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dosen $dosen)
    {
        return response()->json(['data' => $dosen]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detail(Dosen $dosen)
    {
        return response()->json(['data' => $dosen]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dosen $dosen)
    {
        $rules = [
            'name' => 'required',
        ];

        $message = [
            'name.required' => 'Nama dosen wajib diisi.'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        $data = [
            'name' => trim($request->name),
            'nomor_hp' => trim($request->nomor_hp) ?? 0,
        ];

        $result = $dosen->update($data);

        return response()->json(['data' => $result, 'message' => 'Data berhasil disimpan.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dosen $dosen)
    {
        //
    }

    /**
     * Index detail matakuliah dosen.
     */
    public function dosenMatakuliah($dosenId)
    {
        $dosen = Dosen::with('matakuliah')->findOrFail($dosenId);

        return view('admin.dosen.matakuliah.index', compact('dosen'));
    }

    /**
     * data matakuliah dosen.
     */
    public function getDosenMatakuliah(Request $request, $dosenId)
    {
        $query = Matakuliah::whereHas('dosen', function ($q) use ($dosenId) {
            $q->where('dosen_id', $dosenId);
        })->orderBy('id', 'ASC');

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('matakuliah', function ($query) {
                return $query->name;
            })
            ->addColumn('kelas', function ($query) {
                return $query->name;
            })
            ->addColumn('aksi', function ($query) {
                return '
                   <button onclick="deleteMatakuliah(`' . route('dosen.matakuliah_destroy', $query->id) . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * data matakuliah dosen.
     */
    public function matakuliahData(Request $request)
    {
        $query = Matakuliah::whereDoesntHave('dosen', function ($query) use ($request) {
            $query->where('dosen_id', $request->dosen);
        });

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('select_all', function ($query) {
                return '
                    <input type="checkbox" class="matakuliah" name="matakuliah[]" id="matakuliah" value="' . $query->id . '">
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Index detail matakuliah dosen.
     */
    public function dosenMatakuliahStore(Request $request)
    {
        $rules = [
            'dosen_id' => 'required',
            'matakuliah_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors, 'message' => 'Matakuliah gagal dimasukan ke dalam kelas'], 422);
        }

        $dosen = Dosen::findOrfail($request->dosen_id);

        //cek apakah dosen sudah memilih mata kuliah
        if ($dosen->matakuliah()->where('matakuliah_id', $request->matakuliah_id)->exists()) {
            return response()->json(['message' => 'Dosen sudah mengambil matakuliah ini'], 422);
        }

        $dosen->matakuliah()->attach($request->matakuliah_id);

        return response()->json(['message' => 'Matakuliah berhasil disimpan']);

    }

    public function matakuliahDestroy($matakuliahId)
    {
        $matakuliah = Matakuliah::findOrfail($matakuliahId);

        $matakuliah->dosen()->detach();

        return response()->json(['message' => 'Matakuliah berhasil dihapus']);
    }
}
