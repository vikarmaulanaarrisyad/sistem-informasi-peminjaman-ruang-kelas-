@extends('layouts.app')

@section('title', 'Daftar Peminjaman Ruang')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Peminjaman Ruang</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <x-card>
                <x-slot name="header">
                    <div class="d-flex justify-between">
                        <i class="fas fa-qrcode" style="font-size: 1.5em"></i>
                        <span class="ml-1">Scan QR Code Mahasiswa</span>
                    </div>
                </x-slot>

                <div class="row">
                    <div class="col-md-12">
                        <div id="reader" style="width: 100%"></div>
                    </div>
                </div>

                <x-slot name="footer">

                </x-slot>
            </x-card>
        </div>
        <div class="col-md-6 col-lg-6">
            <x-card>
                <x-slot name="header">
                    <div class="d-flex justify-between">
                        <i class="fas fa-plus-circle" style="font-size: 1.5em"></i>
                        <span class="ml-1" style="font-size: 1em">Form Tambah Manual NIM Mahasiswa</span>
                    </div>
                </x-slot>

                <div class="form-group">
                    <label for="nim">NIM <span class="text-danger" style="font-size: 0.80em">Mahasiswa</span></label>
                    <input id="nim" class="form-control" type="number" name="nim"
                        placeholder="Tuliskan NIM Mahasiswa" autocomplete="off">
                </div>

                <x-slot name="footer">
                    <div class="d-flex ">
                        <i class="fas fa-info-circle mr-1" style="color: #17a2b8"></i>
                        <span class="mr-5" style="color: #17a2b8; font-size: 0.85em">Silahkan klik tombol cek untuk
                            melihat data mahasiswa</span>
                        <button onclick="validasiForm()" class="btn btn-xs btn-outline-info" style="width: 100px; "><i
                                class="fas fa-check-circle"></i> Validasi</button>
                    </div>
                </x-slot>

            </x-card>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <span>Daftar Pengembalian Ruang</span>
                </x-slot>

                <x-table class="pengembalian-table">
                    <x-slot name="thead">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>NAMA MAHASISWA</th>
                            <th>RUANGAN</th>
                            <th>PENGEMBALIAN</th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
@endsection

@include('include.datatable')
@include('admin.pengembalian.scripts')
