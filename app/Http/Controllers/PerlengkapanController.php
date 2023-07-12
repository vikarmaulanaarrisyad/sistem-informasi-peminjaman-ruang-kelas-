<?php

namespace App\Http\Controllers;

use App\Models\Perlengkapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PerlengkapanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('admin.perlengkapan.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function data(Request $request)
    {
        $query = Perlengkapan::all();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($query) {
                return '
                    <div class="btn-group">
                    <button onclick="editForm(`' . route('perlengkapan.show', $query->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                     <button onclick="detailForm(`' . route('perlengkapan.detail', $query->id) . '`)" class="btn btn-sm btn-success"><i class="fas fa-eye"></i> Detail</button>
                </div>
                ';
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
            'keterangan' => trim($request->keterangan),
        ];

        $result = Perlengkapan::create($data);

        return response()->json(['data' => $result, 'message' => 'Data berhasil disimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $perlengkapan = Perlengkapan::findOrfail($id);

        return response()->json(['data' => $perlengkapan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detail($id)
    {
        $perlengkapan = Perlengkapan::findOrfail($id);

        return response()->json(['data' => $perlengkapan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $perlengkapan = Perlengkapan::findOrfail($id);

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
            'keterangan' => trim($request->keterangan),
        ];

        $result = $perlengkapan->update($data);

        return response()->json(['data' => $result, 'message' => 'Data berhasil disimpan.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perlengkapan $perlengkapan)
    {
        //
    }
}
