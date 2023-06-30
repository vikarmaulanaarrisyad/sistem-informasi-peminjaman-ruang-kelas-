<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::first();

        return view('admin.setting.index', compact('setting'));
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
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $rules = [
            'nama_aplikasi' => 'required',
            'nama_singkatan' => 'required',
            'diskripsi_aplikasi' => 'nullable',
        ];

        if ($request->hasFile('logo_aplikasi')) {
            $rules = [
                'logo_aplikasi' => 'required|mimes:png,jpg,jpeg|max:2048',
            ];
        }

        $message = [
            'logo_aplikasi.mimes' => 'Logo harus bertipe png,jpg,jpeg.',
            'logo_aplikasi.max' => 'Logo berukuran maksimal 2MB.',
            'nama_aplikasi.required' => 'Nama aplikasi wajib diisi.',
            'nama_singkatan.required' => 'Singkatan aplikasi wajib diisi.',
            'diskripsi_aplikasi.required' => 'Deskripsi aplikasi wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }
        $data = $request->except('logo_aplikasi');
        if ($request->hasFile('logo_aplikasi')) {
            if (Storage::disk('public')->exists($setting->logo_aplikasi)) {
                Storage::disk('public')->delete($setting->logo_aplikasi);
            }
            $data['logo_aplikasi'] = upload('setting', $request->file('logo_aplikasi'), 'setting');
        }

        $setting->update($data);

        return back()->with([
            'message'   => 'Data Pengaturan Berhasil Disimpan.',
            'success' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
