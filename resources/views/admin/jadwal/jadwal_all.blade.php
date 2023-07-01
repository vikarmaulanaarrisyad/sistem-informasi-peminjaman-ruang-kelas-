@extends('layouts.app')

@section('title', 'Jadwal Matakuliah')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('jadwal.index') }}">Jadwal</a></li>
    <li class="breadcrumb-item active">Daftar Jadwal Matakuliah</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Jadwal Matakuliah</span>
                </x-slot>

                <x-table class="jadwal2 hover">
                    <x-slot name="thead">
                        <tr>
                            <th>NO</th>
                            <th>Hari</th>
                            <th>MATAKULIAH</th>
                            <th>DOSEN</th>
                            <th>KELAS</th>
                            <th>MULAI</th>
                            <th>SELESAI</th>
                            <th>RUANG</th>
                            <th>AKSI</th>
                        </tr>
                    </x-slot>
                </x-table>

            </x-card>
        </div>
    </div>
    @includeIf('admin.jadwal.form')

@endsection

@include('include.datepicker')

@include('include.datatable')

@push('scripts')
    <script>
        let table2;
        let modal = '#modal-form';
        let modalDetail = '#modal-detail';
        let button = '#submitBtn';

        table2 = $('.jadwal2').DataTable({
            processing: true,
            autoWidth: false,
            serverSide: true,
            ajax: {
                url: '{{ route('jadwal.data_jadwal') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false,
                    scrollX: true,

                },

                {
                    data: 'hari',

                },
                {
                    data: 'matakuliah'
                },
                {
                    data: 'dosen'
                },
                {
                    data: 'kelas'
                },
                {
                    data: 'waktu_mulai'
                },
                {
                    data: 'waktu_selesai'
                },
                {
                    data: 'ruang'
                },

                {
                    data: 'aksi',
                    sortable: false,
                    searchable: false
                },
            ]
        });

        function editForm(url, title = 'Edit Daftar Jadwal') {
            $.get(url)
                .done(response => {
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('PUT');
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                    resetForm(`${modal} form`);
                    loopForm(response.data);

                    // Tambahkan opsi baru
                    var kelasText = "Kelas " + response.data.kelas.name;
                    var ruangText = "Ruang " + response.data.ruang.name;

                    var kelas = new Option(kelasText, response.data.kelas.id, true, true);
                    var matkul = new Option(response.data.matakuliah.name, response.data.matakuliah.id, true, true);
                    var ruang = new Option(ruangText, response.data.ruang.id, true, true);


                    $('#kelas_id').append(kelas).trigger('change');
                    $('#matakuliah_id').append(matkul).trigger('change');
                    $('#ruang_id').append(ruang).trigger('change');

                    // Menambahkan atribut 'disabled'
                    $('#kelas_id').prop('disabled', true);
                    $('#matakuliah_id').prop('disabled', true);
                    $('#dosen_id').prop('disabled', true);
                    $('#ruang_id').prop('disabled', true);

                    // Misalkan data dari database adalah array yang berisi nilai hari yang dipilih
                    var databaseValues = response.data.hari;

                    // Loop melalui setiap checkbox
                    $('input[name="hari"]').each(function() {
                        var checkboxValue = $(this).val();

                        // Periksa apakah nilai checkbox cocok dengan nilai dari database
                        if (databaseValues.includes(checkboxValue)) {
                            $(this).prop('checked', true);
                            $(this).prop('disabled', true);

                        } else {
                            $(this).prop('disabled', true);
                        }
                    });


                })
                .fail(errors => {
                    Swall.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                });
        }

        function submitForm(originalForm) {
            $(button).prop('disabled', true);
            $('#spinner-border').show();
            $.post({
                    url: $(originalForm).attr('action'),
                    data: new FormData(originalForm),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(response => {
                    $(modal).modal('hide');
                    if (response.status = 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                    }
                    $(button).prop('disabled', false);
                    $('#spinner-border').hide();
                    table.ajax.reload();
                })
                .fail(errors => {
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        $('#spinner-border').hide()
                        $(button).prop('disabled', false);
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }
                });
        }

         function deleteData(url, name) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin?',
                text: 'Anda akan menghapus jadwal ini',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Iya, Hapus!',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                            '_method': 'delete'
                        })
                        .done(response => {
                            if (response.status = 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                                table2.ajax.reload();
                            }
                        })
                        .fail(errors => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps! Gagal!',
                                text: errors.responseJSON.message,
                                showConfirmButton: false,
                                timer: 3000
                            })
                        });
                }
            })
        }

    </script>
@endpush
