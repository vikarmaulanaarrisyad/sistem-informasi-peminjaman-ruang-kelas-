@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('kelas.index') }}">Kelas</a></li>
    <li class="breadcrumb-item active">Tambah Matakuliah</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="mb-3 img-circle" src="{{ asset('assets/icon/ruangkelasicon.png') }}"
                            alt="User profile picture" width="50%">
                    </div>
                    <h3 class="profile-username text-center">Kelas {{ $kelas->name }}</h3>
                    <p class="text-muted text-center">Dosen Wali </p>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <button onclick="addMahasiswaForm()" class="btn btn-outline-primary btn-sm" id="btnTambah"><i
                                    class="fas fa-plus-circle"></i>
                                Tambah
                                Data</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="row">
                            <div class="col-md-12">
                                <x-table class="mahasiswa-table">
                                    <x-slot name="thead">
                                        <tr>
                                            <th>No</th>
                                            <th>NAMA MATKUL</th>
                                            <th>NAMA</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </x-slot>
                                </x-table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @includeIf('admin.kelas.form_mahasiswa')
@endsection
@include('include.datatable')
