@extends('layouts.app')

@section('title', 'Daashboard')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Mahasiswa</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <x-card>
                <x-slot name="header">
                    <h5><i class="fas fa-qrcode"></i> QR Code</h5>
                </x-slot>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            {!! QrCode::size(256)->generate($mahasiswa->nim) !!}
                        </div>
                    </div>
                </div>

                <x-slot name="footer">
                    <div class="text-info"> <i class="fas fa-info-circle"></i>
                        <span>Gunakan QR Code untuk melakukan peminjaman ruang kelas ke admin prodi</span>
                    </div>
                </x-slot>
            </x-card>
        </div>
    </div>
@endsection
