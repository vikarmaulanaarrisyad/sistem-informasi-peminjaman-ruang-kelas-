<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function index(Request $request)
    {
        $start = now()->subDays(30)->format('Y-m-d');
        $end = date('Y-m-d');

        if ($request->has('start') && $request->start != "" && $request->has('end') && $request->end != "") {
            $start = $request->start;
            $end = $request->end;
        }

        return view('admin.report.index', compact('start', 'end'));
    }

    public function getData($start, $end)
    {
        $data = [];
        $i = 1;

        $peminjaman = Peminjaman::with('jadwal','mahasiswa')
            ->whereBetween('created_at',[$start,$end])
            ->get();

        if ($peminjaman->isEmpty()) {
            $data[] = [
                'DT_RowIndex' => '',
                'tanggal' => '',
                'mahasiswa' => '',
                'ruang' => '',
                'jammulai' => '',
                'jamselesai' => '',
                'status' => '',
            ];
        } else {
            foreach ($peminjaman as $pinjam) {
                $row = [];
                $row['DT_RowIndex'] = $i++;
                $row['tanggal'] = tanggal_indonesia($pinjam->created_at, strtotime($pinjam->created_at));
                $row['mahasiswa'] = $pinjam->mahasiswa->name ?? '';
                $row['ruang'] = $pinjam->jadwal->ruang->name ?? '';
                $row['jammulai'] = $pinjam->jadwal->waktu_mulai;
                $row['jamselesai'] = $pinjam->jadwal->waktu_selesai;
                $row['status'] = '<span class=" badge badge-' . $pinjam->statusColor() . ' ">' . $pinjam->statusText() . '</span >';

                $data[] = $row;
            }
        }

        return $data;
    }

    public function data($start, $end)
    {
        $data = $this->getData($start, $end);

        return datatables($data)
            ->escapeColumns([])
            ->make(true);
    }

    public function exportPDF($start, $end)
    {
        $data = $this->getData($start, $end);
        $pdf = PDF::loadView('admin.report.pdf', compact('start', 'end', 'data'));

        return $pdf->stream('Laporan-peminjaman-alat-' . date('Y-m-d-his') . '.pdf');
    }
}
