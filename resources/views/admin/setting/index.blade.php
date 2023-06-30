@extends('layouts.app')

@section('title', 'Pengaturan Aplikasi')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Pengaturan Aplikasi</li>
@endsection

@section('content')
    <form action="{{ route('setting.update', $setting->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ Storage::url($setting->logo_aplikasi ?? '') }}" alt="Logo Aplikasi">
                        </div>
                        <br>

                        <div class="form-group mt-2">
                            <input type="file" id="logo_aplikasi" name="logo_aplikasi"
                                class="form-control @error('logo_aplikasi') is-invalid @enderror">

                            @error('logo_aplikasi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <p class="text-info">File harus bertipe jpg, png, jpeg ukuran max 2MB. serta berukuran 400x400</p>

                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_aplikasi">Pengaturan <span class="text-danger"
                                            style="font-size: 0.80em;">Nama Aplikasi</span></label>
                                    <input id="nama_aplikasi" class="form-control form-control-border" type="text"
                                        name="nama_aplikasi" value="{{ $setting->nama_aplikasi }}"
                                        placeholder="Tuliskan nama aplikasi" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_singkatan">Pengaturan <span class="text-danger"
                                            style="font-size: 0.80em;">Nama Singkatan Aplikasi</span></label>
                                    <input id="nama_singkatan" class="form-control form-control-border" type="text"
                                        value="{{ $setting->nama_singkatan }}" name="nama_singkatan"
                                        placeholder="Tuliskan singkatan nama aplikasi" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="diskripsi_aplikasi">Pengaturan <span class="text-danger"
                                            style="font-size: 0.80em;">Tentang Aplikasi</span></label>

                                    <textarea class="form-control" name="diskripsi_aplikasi" id="" cols="30" rows="5">{{ $setting->diskripsi_aplikasi ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex">
                            <button class="btn btn-outline-primary btn-sm" style="width: 150px"><i class="fas fa-save"></i>
                                Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

<x-notif></x-notif>
