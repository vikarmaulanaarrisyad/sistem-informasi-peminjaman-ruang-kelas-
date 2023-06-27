@extends('layouts.app')

@section('title', 'Daftar Jadwal')

{{-- @section('header', 'Daftar Mahasiswa') --}}

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Jadwal</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <x-card>
                <x-slot name="header">
                  {{-- <button onclick="addForm(`{{ route('jadwal.store') }}`)" class="btn btn-outline-primary btn-sm"><i
                            class="fas fa-plus-circle"></i> Tambah Data</button> --}}
                            <h5>Jadwal Matakuliah Hari Ini</h5>
                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <tr>
                            <th>NO</th>
                            <th>MATAKULIAH</th>
                            <th>DOSEN</th>
                            <th>KELAS</th>
                            <th>MULAI</th>
                            <th>SELESAI</th>
                            <th>RUANG</th>
                            <th>AKSI</th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @includeIf('admin.jadwal.form')
    @includeIf('admin.jadwal.form_peminjaman')
@endsection
@include('include.datatable')
@include('admin.jadwal.scripts')
