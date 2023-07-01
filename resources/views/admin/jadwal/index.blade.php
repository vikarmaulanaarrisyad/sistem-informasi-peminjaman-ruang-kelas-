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
                    <div class="d-sm-flex flex-row">
                        @if (auth()->user()->hasRole('admin'))
                            <button onclick="createForm()" class="btn btn-outline-primary btn-sm mr-3"><i
                                    class="fas fa-plus-circle"></i> Tambah
                                Data</button>
                            <button onclick="viewJadwalAll()" class="btn btn-outline-info btn-sm"><i
                                    class="fas fa-eye"></i> Lihat Semua Jadwal</button>
                        @endif

                    </div>
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
@include('include.datepicker')
@include('admin.jadwal.scripts')
