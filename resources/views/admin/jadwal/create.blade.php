@extends('layouts.app')

@section('title', 'Tambah Jadwal')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('jadwal.index') }}">Jadwal</a></li>
    <li class="breadcrumb-item active">Tambah Jadwal</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" id="form">
                <x-card>
                    <x-slot name="header">
                        <h5>Form Tambah Jadwal Kuliah</h5>
                    </x-slot>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="dosen">Pilih Dosen</label>
                                <select name="dosen_id" id="dosen_id" class="form-control select2" style="width: 100%">
                                    <option disabled selected>Pilih salah satu</option>
                                    @foreach ($daftarDosen as $dosen)
                                        <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="matakuliah">Pilih Matkul</label>
                                <select name="matakuliah_id" id="matakuliah_id" class="form-control select2" style="width: 100%">
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="kelas">Pilih Kelas</label>
                                <select name="kelas_id" id="kelas_id" class="form-control select2" style="width: 100%">
                                    <option disabled selected>Pilih salah satu</option>

                                    @foreach ($daftarKelas as $kelas)
                                        <option value="{{ $kelas->id }}">Kelas {{ $kelas->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="ruang">Pilih Ruang</label>
                                <select name="ruang_id" id="ruang_id" class="form-control" style="width: 100%">
                                    <option disabled selected>Pilih salah satu</option>
                                    @foreach ($daftarRuang as $ruang)
                                        <option value="{{ $ruang->id }}">{{ $ruang->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="waktu_mulai">Waktu Mulai</label>
                                <div class="input-group time" id="waktu_mulai" data-target-input="nearest">
                                    <input type="text" name="waktu_mulai" class="form-control datetimepicker-input"
                                        data-target="#waktu_mulai" data-toggle="datetimepicker" />
                                    <div class="input-group-append" data-target="#waktu_mulai" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="waktu_selesai">Waktu Selesai</label>
                                <div class="input-group time" id="waktu_selesai" data-target-input="nearest">
                                    <input type="text" name="waktu_selesai" class="form-control datetimepicker-input"
                                        data-target="#waktu_selesai" data-toggle="datetimepicker" />
                                    <div class="input-group-append" data-target="#waktu_selesai"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="my-input">Pilih Hari</label>
                                <div class="d-flex">
                                    @foreach ($namaHari as $hari)
                                        <div class="form-check ml-2">
                                            <input class="form-check-input" type="checkbox" name="hari[]" id="hari"
                                                value="{{ $hari }}">
                                            <label class="form-check-label">{{ $hari }}</label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>

                    <x-slot name=footer>
                        <button type="button" onclick="submitForm(`{{ route('jadwal.store') }}`)"
                            class="btn btn-sm btn-outline-primary" id="submitBtn">
                            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                            <i class="fas fa-save mr-1"></i>
                            Simpan</button>
                        <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-times"></i>
                            Close
                        </button>
                    </x-slot>
                </x-card>
            </form>

        </div>
    </div>
@endsection

@include('include.select2')

@include('include.datepicker')

@push('scripts')
    <script>
        let button = '#submitBtn';
        $(document).ready(function() {
            $('#spinner-border').hide();
        });

        $('#dosen_id').on('change', function() {
            let dosenId = $('[name=dosen_id]').val();

            if (dosenId) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('jadwal.dosen.data') }}",
                    data: {
                        "dosen_id": dosenId
                    },
                    dataType: "json",
                    success: function(response) {
                        var matakuliah = response.data.matakuliah;
                        $('#matakuliah_id').empty();
                        $('#matakuliah_id').append(
                            '<option disabled selected>Pilih salah satu</option>').trigger('change');

                        matakuliah.forEach(function(matkul) {
                            var option = new Option(matkul.name, matkul.id, true, true);
                            $('#matakuliah_id').append(option).trigger('change');
                        })

                    }
                });
            } else {
                $('#matakuliah_id').empty();

            }


        });

        function submitForm(url) {
            $(button).prop('disabled', true);
            $('#spinner-border').show();

            $.ajax({
                type: "POST",
                url: url,
                data: $('#form').serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.status = 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            location.reload();
                        })
                    }
                    $(button).prop('disabled', false);
                    $('#spinner-border').hide();
                },
                error: function(errors) {
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    if (errors.status == 422) {
                        $('#spinner-border').hide()
                        $(button).prop('disabled', false);
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }
                }
            });
        }
    </script>
@endpush
