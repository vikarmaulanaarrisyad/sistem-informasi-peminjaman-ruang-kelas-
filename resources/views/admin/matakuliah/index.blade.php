@extends('layouts.app')

@section('title', 'Daftar Matkul')

{{-- @section('header', 'Daftar Mahasiswa') --}}

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Matkul</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <x-card>
                <x-slot name="header">
                  <button onclick="addForm(`{{ route('matakuliah.store') }}`)" class="btn btn-outline-primary btn-sm"><i
                            class="fas fa-plus-circle"></i> Tambah Data</button>
                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <tr>
                            <th>NO</th>
                            <th>NAMA MATAKULIAH</th>
                            <th>AKSI</th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @includeIf('admin.matakuliah.form')
    @includeIf('admin.matakuliah.detail')
@endsection
@include('include.datatable')
@include('admin.matakuliah.scripts')
