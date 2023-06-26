<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
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
                     <button onclick="detailForm(`' . route('dosen.detail', $query->id) . '`)" class="btn btn-sm btn-success"><i class="fas fa-eye"></i> Matakuliah</button>
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
            'nomor_hp' => 'required|numeric|min:11',
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
            'nomor_hp' => trim($request->nomor_hp),
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
            'nomor_hp' => 'required|numeric|min:11',
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
            'nomor_hp' => trim($request->nomor_hp),
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
}
