@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('kelas.index') }}">Kelas</a></li>
    <li class="breadcrumb-item active">Tambah Mahasiswa</li>
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
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Total Mahasiswa</b> <a class="float-right">1</a>
                        </li>
                        <li class="list-group-item">
                            <b>Jumlah Laki-laki</b> <a class="float-right">543</a>
                        </li>
                        <li class="list-group-item">
                            <b>Jumlah Perempuan</b> <a class="float-right">13,287</a>
                        </li>
                    </ul>
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
                                            <th>NIM</th>
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


@push('scripts')
    <script>
        let modal = '#modal-form';
        let modalDetail = '#modal-detail';
        let button = '#submitBtn';
        let table, table2;

        $(document).ready(function() {
            $('#spinner-border').hide();
        });

        table = $('.table-mahasiswa').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('kelas.mahasiswa.data') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'select_all',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'nim'
                },
                {
                    data: 'name'
                },
            ]
        });

        table2 = $('.mahasiswa-table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('kelas.get_kelas_mahasiswa', $kelas->id) }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },

                {
                    data: 'nim'
                },
                {
                    data: 'name'
                },
                 {
                    data: 'aksi',
                    searchable: false,
                    sortable: false
                },
            ]
        });

        $("#select_all").on('click', function() {
            var isChecked = $("#select_all").prop('checked');

            $(".mahasiswa").prop('checked', isChecked);
            $("#submitBtn").prop('disabled', !isChecked);
        });

        $('#btnTambah').on('click', function() {
            let checkbox = $('#modal-form #table tbody .mahasiswa:checked');

            if (checkbox.length > 0) {
                $("#submitBtn").prop('disabled', false);
            }
            $("#submitBtn").prop('disabled', true);
        })

        $("#table tbody").on('click', '.mahasiswa', function() {
            if ($(this).prop('checked') != true) {
                $("#select_all").prop('checked', false);
            }

            let semua_checkbox = $("#table tbody .mahasiswa:checked")

            let mahasiswa = (semua_checkbox.length > 0)

            $("#submitBtn").prop('disabled', !mahasiswa)
        })

        function addMahasiswaForm(title = "Tambah Mahasiswa") {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            resetForm(`${modal} form`);
        }

        function submitForm(url, kelasId) {

            $('#spinner-border').show();
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin?',
                text: 'Anda akan menginputkan mahasiswa terpilih.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Iya !',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let checkbox_terpilih = $('#modal-form #table tbody .mahasiswa:checked')
                    let semua_id = []

                    $.each(checkbox_terpilih, function(index, elm) {
                        semua_id.push(elm.value)
                    });

                    $(button).prop('disabled', true);

                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            'mahasiswa_id': semua_id,
                            'kelas_id': kelasId
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status = 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            }
                            $(modal).modal('hide');
                            $(button).prop('disabled', false);
                            $('#spinner-border').hide();
                            table.ajax.reload();
                            table2.ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            // Menyembunyikan spinner loading
                            $('#spinner-border').hide();

                            // Menampilkan pesan error
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps! Gagal',
                                text: xhr.responseJSON.message,
                                showConfirmButton: true,
                            });

                            // Refresh tabel atau lakukan operasi lain yang diperlukan
                            table.ajax.reload();
                            table2.ajax.reload();

                        }
                    });
                }
            });
        }

        function deleteMahasiswa(url) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin?',
                text: 'Anda akan menghapus mahasiswa terpilih.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Iya !',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "delete",
                        url: url,
                        dataType: "json",
                        success: function(response) {
                            if (response.status = 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            }
                            table2.ajax.reload();
                            table.ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            // Menampilkan pesan error
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps! Gagal',
                                text: xhr.responseJSON.message,
                                showConfirmButton: true,
                            });

                            // Refresh tabel atau lakukan operasi lain yang diperlukan
                            table2.ajax.reload();
                            table.ajax.reload();

                        }
                    });
                }
            });
          }
    </script>
@endpush
