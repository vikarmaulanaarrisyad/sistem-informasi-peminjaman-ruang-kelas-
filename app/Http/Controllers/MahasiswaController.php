<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.mahasiswa.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function data()
    {
        $query = Mahasiswa::with('user', 'kelas_mahasiswa');

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('foto', function ($query) {
                if (!empty($query->user->path_image != "default.jpg")) {
                    return '
                        <img class="img-circle img-responsive" src="' . Storage::url($query->user->path_image) . '" style="width:40px; height:40px">
                    ';
                }
                return '
                    <img src="' . asset('assets/images/not.png') . '" class="thumbnail img-responsive" style="width:40px">
                ';
            })
            ->addColumn('nomor_hp', function ($query) {
                return $query->nomor_hp;
            })
            ->addColumn('kelas', function ($query) {
                if ($query->kelas_mahasiswa === NULL) {
                    return '
                        <a href="' . route('kelas.index') . '" class="btn btn-sm btn-primary"><i class="fas fa-graduation-cap"></i> Pilih kelas</a>
                    ';
                }

                foreach ($query->kelas_mahasiswa as $kelas) {
                    return '
                    <span class="badge badge-success">kelas ' . $kelas->name.'</span>
                   ';
                }
            })
            ->addColumn('aksi', function ($query) {
                return '
                <div class="btn-group">
                <button onclick="detailForm(`' . route('mahasiswa.detail', $query->id) . '`)" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> Detail</button>
                </div>
                ';
                // <button onclick="editForm(`' . route('mahasiswa.show', $query->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detail($id)
    {
        $mahasiswa  = Mahasiswa::with('user','kelas_mahasiswa')->findOrFail($id);

        $mahasiswa->foto = Storage::url($mahasiswa->user->path_image ?? '');
        $mahasiswa->name = $mahasiswa->name;
        $mahasiswa->nim = $mahasiswa->nim;
        $mahasiswa->nomor_hp = $mahasiswa->nomor_hp;

        return response()->json(['data' => $mahasiswa]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        //
    }
}
