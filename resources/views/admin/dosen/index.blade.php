@extends('layouts.app')

@section('title', 'Daftar Mahasiswa')

{{-- @section('header', 'Daftar Mahasiswa') --}}

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Mahasiswa</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <x-card>
                <x-slot name="header">
                  <button onclick="addForm(`{{ route('dosen.store') }}`)" class="btn btn-outline-primary btn-sm"><i
                            class="fas fa-plus-circle"></i> Tambah Data</button>
                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <tr>
                            <th>NO</th>
                            <th>FOTO</th>
                            <th>NAMA DOSEN</th>
                            <th>NOMOR HP</th>
                            <th>AKSI</th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @includeIf('admin.dosen.form')
    @includeIf('admin.dosen.detail')
@endsection
@include('include.datatable')
@include('admin.dosen.scripts')
