<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Peminjaman;
use App\Models\Ruang;
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

        $peminjaman = Peminjaman::with(['jadwal', 'mahasiswa', 'jadwal.ruang', 'jadwal.ruang.perlengkapan'])
            ->whereBetween('created_at', [$start, $end])
            ->get();

        if ($peminjaman->isEmpty()) {
            // ...
        } else {
            foreach ($peminjaman as $pinjam) {
                $row = [];
                $row['DT_RowIndex'] = $i++;
                $row['tanggal'] = tanggal_indonesia($pinjam->created_at, strtotime($pinjam->created_at));
                $row['mahasiswa'] = $pinjam->mahasiswa->name ?? '';
                $row['ruang'] = $pinjam->jadwal->ruang->name ?? '';
                $row['jammulai'] = $pinjam->jadwal->waktu_mulai;
                $row['jamselesai'] = $pinjam->jadwal->waktu_selesai;

                $perlengkapanInfo = '';
                $keterangan = '';
                foreach ($pinjam->jadwal->ruang->perlengkapan as $perlengkapan) {
                    $perlengkapanInfo .= $perlengkapan->name . ', ' . '<br>';
                    $keterangan .= $perlengkapan->keterangan . ', ' . '<br>';
                }
                $perlengkapanInfo = rtrim($perlengkapanInfo, ', '); // Menghilangkan koma di akhir
                $row['perlengkapan'] = $perlengkapanInfo;
                $row['keterangan'] = $keterangan;
                $row['status'] = '<span class="badge badge-' . $pinjam->statusColor() . '">' . $pinjam->statusText() . '</span>';

                $row['aksi'] = ' <button onclick="detailForm(`' . route('peminjaman.detail', $pinjam->id) . '`, `' . $pinjam->jadwal->ruang->name . '`)" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Detail</button>';

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
        $pdf = PDF::loadView('admin.report.pdf', compact('start', 'end', 'data'))->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan-peminjaman-alat-' . date('Y-m-d-his') . '.pdf');
    }
}
