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
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('dosen.data') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'foto',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'name'
                },
                {
                    data: 'nomor_hp'
                },
                {
                    data: 'aksi',
                    sortable: false,
                    searchable: false
                },
            ]
        });

        function addForm(url, title = 'Tambah Daftar Dosen') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('POST');
            $('#spinner-border').hide();
            $(button).prop('disabled', false);
            resetForm(`${modal} form`);
        }

        function editForm(url, title = 'Edit Daftar Dosen') {
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

        function detailDosenMatkulForm(dosenId, title = 'Detail Matakuliah Dosen') {

            var url = "{{ route('dosen.matakuliah.index', ['dosen_id' => ':dosen_id']) }}";

            url = url.replace(':dosen_id', dosenId);

            window.location.href = url;

            $.ajax({
                type: "GET",
                url: url,
                data: {
                    'dosen_id': dosenId,
                },
                dataType: "json",
                success: function(response) {
                    window.location.href = url;
                },
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
    </script>
@endpush
