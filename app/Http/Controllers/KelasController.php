<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('admin.kelas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function data(Request $request)
    {
        $query = Kelas::all();

        return datatables($query)
            ->addIndexColumn()

            ->addColumn('aksi', function ($query) {
                return '
                    <div class="btn-group">
                    <button onclick="editForm(`' . route('kelas.show', $query->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                     <button onclick="detailForm(`' . route('kelas.detail', $query->id) . '`)" class="btn btn-sm btn-success"><i class="fas fa-eye"></i> Detail</button>
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
            'name.required' => 'Nama kelas wajib diisi.'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        $data = [
            'name' => trim($request->name),
        ];

        $result = Kelas::create($data);

        return response()->json(['data' => $result, 'message' => 'Data berhasil disimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kelas = Kelas::findOrfail($id);

        return response()->json(['data' => $kelas]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detail($id)
    {
        $kelas = Kelas::findOrfail($id);

        return response()->json(['data' => $kelas]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $kelas = Kelas::findOrfail($id);

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
        ];

        $result = $kelas->update($data);

        return response()->json(['data' => $result, 'message' => 'Data berhasil disimpan.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        //
    }
}
