<?php

namespace App\Http\Controllers;

use App\Models\Perlengkapan;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perlengkapan = Perlengkapan::all();

        return view('admin.ruang.index', compact('perlengkapan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function data(Request $request)
    {
        $query = Ruang::all();

        return datatables($query)
            ->addIndexColumn()

            ->addColumn('aksi', function ($query) {
                return '
                    <div class="btn-group">
                    <button onclick="editForm(`' . route('ruang.show', $query->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                     <button onclick="detailForm(`' . route('ruang.detail', $query->id) . '`)" class="btn btn-sm btn-success"><i class="fas fa-eye"></i> Detail</button>
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
            'alat_id' => 'required'
        ];

        $message = [
            'name.required' => 'Nama ruangan wajib diisi.',
            'alat_id.required' => 'Perlengkapan ruangan wajib diisi.'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        $data = [
            'name' => trim($request->name),
        ];

        $result = Ruang::create($data);

        $result->perlengkapan()->attach($request->alat_id);

        return response()->json(['data' => $result, 'message' => 'Data berhasil disimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ruang = Ruang::with('perlengkapan')-> findOrfail($id);

        return response()->json(['data' => $ruang]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detail($id)
    {
        $ruang = Ruang::with('perlengkapan')->findOrfail($id);

        return response()->json(['data' => $ruang]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $ruang = Ruang::with('perlengkapan')->findOrfail($id);

        $rules = [
            'name' => 'required',
            'alat_id' => 'required'
        ];

        $message = [
            'name.required' => 'Nama ruangan wajib diisi.',
            'alat_id.required' => 'Perlengkapan ruangan wajib diisi.'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        $data = [
            'name' => trim($request->name),
        ];

        $ruang->update($data);

        $ruang->perlengkapan()->sync($request->alat_id);

        return response()->json(['data' => $ruang, 'message' => 'Data berhasil disimpan.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
