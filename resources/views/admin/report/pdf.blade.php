<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Peminjaman Alat</title>

    <link rel="stylesheet" href="{{ public_path('/AdminLTE/dist/css/adminlte.min.css') }}">
</head>

<body>

    <h4 class="text-center">Laporan Peminjaman Alat PHB</h4>
    <p class="text-center">
        Tanggal {{ tanggal_indonesia($start) }}
        s/d
        Tanggal {{ tanggal_indonesia($end) }}
    </p>

    <table class="table table-striped table-sm" style="width: 100%">
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th style="text-align: center">Hari / Tanggal</th>
                <th style="text-align: center">Mahasiswa</th>
                <th style="text-align: center">Nama Ruang</th>
                <th style="text-align: center">Jam Mulai</th>
                <th style="text-align: center">Jam Selesai</th>
                <th style="text-align: center">Nama Alat</th>
                <th style="text-align: center">Keterangan</th>
                <th style="text-align: center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($row as $key => $col)
                        @if ($key !== 'aksi')
                            <td {!! $key > 1 ? 'class="text-left"' : '' !!}>{!! $col !!}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        <p class="text-right mr-4" style="margin-bottom: 0">Tegal, {{ tanggal_indonesia(Date('Y-m-d')) }}</p>
        <p class="text-right mr-5" style="margin-bottom: 0">Disahkan Oleh</p>
        <p class="text-right text-bold" style="margin-right: 4.5em">Ka Prodi</p>
        <p class="text-right mr-1"
            style="margin-right: 4.5em; margin-top: 4em; text-decoration: underline; margin-bottom: 0px;">Ida Afriliana,
            S.T., M.Kom</p>
        <p class="text-right" style="margin-right: 2.5em">NIPY. 12.013.168</p>
    </div>

</body>

</html>
