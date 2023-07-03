@extends('layouts.app')

@section('title', 'Daftar Peminjaman Ruang')

{{-- @section('header', 'Daftar Mahasiswa') --}}

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Peminjaman Ruang</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <x-card>
                <x-slot name="header">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Daftar Peminjaman</span>
                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <tr>
                            <th>NO</th>
                            <th>JADWAL</th>
                            <th>NAMA MAHASISWA</th>
                            <th>STATUS</th>
                            <th>MULAI</th>
                            <th>SELESAI</th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @includeIf('admin.peminjaman.form')
    @includeIf('admin.peminjaman.detail')
@endsection
@include('include.datatable')
@include('admin.peminjaman.scripts')
