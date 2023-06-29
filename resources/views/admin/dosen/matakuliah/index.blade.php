@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dosen.index') }}">Dosen</a></li>
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
                    <h3 class="profile-username text-center">{{ $dosen->name }}</h3>
                    <p class="text-muted text-center">Dosen Wali </p>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <div class="btn-group">
                                <button onclick="addMatakuliahDosen()"
                                    class="btn btn-outline-primary btn-sm" id="btnTambah"><i class="fas fa-plus-circle"></i>
                                    Tambah
                                    Data</button>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="row">
                            <div class="col-md-12">
                                <x-table class="dosen-table">
                                    <x-slot name="thead">
                                        <tr>
                                            <th>No</th>
                                            <th>MATAKULIAH</th>
                                            <th>KELAS</th>
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
    @includeIf('admin.dosen.matakuliah.form')
@endsection
@include('include.datatable')


@push('scripts')
    <script>
        let modal = '#modal-form';
        let modalDetail = '#modal-detail';
        let button = '#submitBtn';
        let table1, table2;

        $(document).ready(function() {
            $('#spinner-border').hide();
        });

        table1 = $('.dosen-table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('dosen.get_matakuliah_dosen', $dosen->id) }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'matakuliah'
                },
                {
                    data: 'kelas'
                },
                {
                    data: 'aksi',
                    searchable: false,
                    sortable: false
                },
            ]
        });


        table2 = $('.matakuliah-table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('dosen.matakuliah.data', $dosen->id) }}',
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
                    data: 'name'
                },
            ]
        });

        $("#select_all").on('click', function() {
            var isChecked = $("#select_all").prop('checked');

            $(".matakuliah").prop('checked', isChecked);
            $("#submitBtn").prop('disabled', !isChecked);
        });

        $('#btnTambah').on('click', function() {
            let checkbox = $('#modal-form #table tbody .matakuliah:checked');

            if (checkbox.length > 0) {
                $("#submitBtn").prop('disabled', false);
            }
            $("#submitBtn").prop('disabled', true);
        })

        $("#table tbody").on('click', '.matakuliah', function() {
            if ($(this).prop('checked') != true) {
                $("#select_all").prop('checked', false);
            }

            let semua_checkbox = $("#table tbody .matakuliah:checked")

            let matakuliah = (semua_checkbox.length > 0)

            $("#submitBtn").prop('disabled', !matakuliah)
        })

        function addMatakuliahDosen(title = "Tambah Matakuliah Dosen") {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            resetForm(`${modal} form`);
        }

        function submitForm(url, dosenId) {
            
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
                text: 'Anda akan menginputkan matakuliah terpilih.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Iya !',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let checkbox_terpilih = $('#modal-form #table tbody .matakuliah:checked')
                    let semua_id = []

                    $.each(checkbox_terpilih, function(index, elm) {
                        semua_id.push(elm.value)
                    });

                    $(button).prop('disabled', true);

                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            'matakuliah_id': semua_id,
                            'dosen_id': dosenId
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

                            table1.ajax.reload();
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
                            table1.ajax.reload();
                            table2.ajax.reload();

                        }
                    });
                }
            });
        }

        function deleteMatakuliah(url) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin?',
                text: 'Anda akan menghapus matakuliah terpilih.',
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
                            table1.ajax.reload();
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
                            table1.ajax.reload();

                        }
                    });
                }
            });
        }
    </script>
@endpush
