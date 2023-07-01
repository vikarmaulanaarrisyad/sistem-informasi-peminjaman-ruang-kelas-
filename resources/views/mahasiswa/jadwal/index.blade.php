@extends('layouts.app')

@section('title', 'Daftar Jadwal')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Jadwal</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <x-card>
                <x-slot name="header">
                    <h5><i class="fas fa-calendar-alt"></i> Jadwal Matakuliah hari ini</h5>
                </x-slot>

                <x-table class="jadwal-mahasiswa">
                    <x-slot name="thead">
                        <tr>
                            <th>NO</th>
                            <th>HARI</th>
                            <th>MATAKULIAH</th>
                            <th>DOSEN</th>
                            <th>KELAS</th>
                            <th>MULAI</th>
                            <th>SELESAI</th>
                            <th>RUANG</th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
@endsection

@include('include.datatable')
@push('scripts')
    <script>
        let table;

        table = $('.jadwal-mahasiswa').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('mahasiswa.jadwal.data') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },

                {
                    data: 'hari'
                },
                {
                    data: 'matakuliah'
                },
                {
                    data: 'dosen'
                },
                {
                    data: 'kelas'
                },
                {
                    data: 'waktu_mulai'
                },
                {
                    data: 'waktu_selesai'
                },
                {
                    data: 'ruang'
                },

            ]
        });
    </script>
@endpush
