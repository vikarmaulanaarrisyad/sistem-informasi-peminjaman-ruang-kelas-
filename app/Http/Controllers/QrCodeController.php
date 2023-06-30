<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class QrCodeController extends Controller
{
    public function download($nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if ($mahasiswa) {
            $qrCode = QrCode::size(256)->generate($nim);
            $filename = 'qrcode_' . $nim . '.png';

            $path = 'qrcodes/' . $filename;

            Storage::put($path, $qrCode);

            // Simpan nama file ke kolom qr_code pada tabel mahasiswa
            $mahasiswa->qrcode = $filename;
            $mahasiswa->save();

            return response()->download(storage_path('app/' . $path), $filename)->deleteFileAfterSend();
        } else {
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }
    }
}
