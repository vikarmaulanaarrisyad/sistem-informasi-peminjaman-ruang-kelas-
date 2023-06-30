@extends('layouts.app')

@section('title', 'Daftar Peminjaman Ruang')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Peminjaman Ruang</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ asset('AdminLTE') }}/dist/img/user4-128x128.jpg" alt="User profile picture">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#datapribadi" data-toggle="tab"><i
                                    class="fas fa-user"></i> Data
                                Pribadi</a></li>
                        <li class="nav-item"><a class="nav-link" href="#pinjam" data-toggle="tab"><i
                                    class="fas fa-university"></i> History</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="datapribadi">
                            <table class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>:</th>
                                        <th>{{ $mahasiswa->nim }}</th>
                                    </tr>
                                    <tr>
                                        <th>NAMA</th>
                                        <th>:</th>
                                        <th>{{ $mahasiswa->name }}</th>
                                    </tr>
                                    <tr>
                                        <th>NOMOR HP</th>
                                        <th>:</th>
                                        <th>{{ $mahasiswa->nomor_hp }}</th>
                                    </tr>
                                    <tr>
                                        <th>KELAS</th>
                                        <th>:</th>
                                        <th>{{ $mahasiswa->kelas_mahasiswa->pluck('name')->implode(', ') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane" id="pinjam">
                            @if ($peminjaman != NULL)
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Hari/Tanggal</th>
                                            <th>Matakuliah</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($peminjaman as $pinjam)
                                            <tr>
                                                <td> {{ tanggal_indonesia($pinjam->created_at, true) }}</td>
                                                <td> {{ $pinjam->jadwal->matakuliah->name }}</td>
                                                <td>
                                                    @if ($pinjam->status == 'pinjam')
                                                        <span class="badge badge-danger">Belum Dikembalikan</span>
                                                    @else
                                                        <span class="badge badge-success">Sudah Dikembalikan</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <span>Belum ada history</span>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="card-footer">

                </div>
            </div>

        </div>

    </div>
@endsection
