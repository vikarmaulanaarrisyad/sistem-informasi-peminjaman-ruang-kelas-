@push('scripts')
    <script>
        let modal = '#modal-form';
        let modalDetail = '#modal-detail';
        let button = '#submitBtn';
        let table;

        $(function() {
            $('#spinner-border').hide();
        });

        table = $('#table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('jadwal.data') }}',
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

        function addForm(url, title = 'Tambah Daftar Jadwal') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('POST');
            $('#spinner-border').hide();
            $(button).prop('disabled', false);
            resetForm(`${modal} form`);
        }

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

        function detailForm(url, title = 'Scan QRCode') {
            $.get(url)
                .done(response => {
                    $(modalDetail).modal('show');
                    $(`${modalDetail} .modal-title`).text(title);
                    ScanQR(response.data.id);
                })

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
                text: 'Anda akan menghapus petugas ' + name +
                    ' !',
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
                                table.ajax.reload();
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
                            table.ajax.reload();
                        });
                }
            })
        }

        function ScanQR(jadwalId) {
            function onScanSuccess(decodedText, decodedResult) {
                let nim = decodedText;
                csrf_token = $('meta[name="csrf-token"]').attr('content');
                html5QrcodeScanner.clear();

                $(modalDetail).modal('hide');

                Swal.fire({
                    icon: 'warning',
                    title: 'Scan berhasil',
                    text: 'NIM Mahasiswa ' + nim,
                    showConfirmButton: false,
                    timer: 3000
                }).then(() => {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('peminjaman.store') }}",
                        data: {
                            'nim': nim,
                            'jadwal_id': jadwalId,
                            '_token': csrf_token
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 3000
                            }).then(() => {
                                table.ajax.reload();
                                window.location.href = '{{ route('peminjaman.index') }}';
                            });
                        },
                        error: function(response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps! Gagal!',
                                text: response.responseJSON.message,
                                showConfirmButton: false,
                                timer: 3000
                            }).then(() => {
                                table.ajax.reload();

                                // window.location.href = '{{ route('jadwal.index') }}';
                            });
                        }
                    });
                });

            }

            function onScanFailure(error) {
                // handle scan failure, usually better to ignore and keep scanning.
                // for example:
                // console.warn(`Code scan error = ${error}`);
            }

            let html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },
                /* verbose= */
                false);
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        }

        function createForm() {
            window.location.href = '{{ route('jadwal.create') }}';
        }
    </script>
@endpush
