@extends('layouts.app')

@section('title', 'Daftar Perlengkapan')

{{-- @section('header', 'Daftar Mahasiswa') --}}

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Perlengkapan Ruang</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <x-card>
                <x-slot name="header">
                  <button onclick="addForm(`{{ route('perlengkapan.store') }}`)" class="btn btn-outline-primary btn-sm"><i
                            class="fas fa-plus-circle"></i> Tambah Data</button>
                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <tr>
                            <th>NO</th>
                            <th>NAMA PERLENGKAPAN</th>
                            <th>Keterangan</th>
                            <th>AKSI</th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @includeIf('admin.perlengkapan.form')
    @includeIf('admin.perlengkapan.detail')
@endsection
@include('include.datatable')
@include('admin.perlengkapan.scripts')
