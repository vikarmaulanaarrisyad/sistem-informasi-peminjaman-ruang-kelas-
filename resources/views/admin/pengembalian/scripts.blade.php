@push('scripts_vendor')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
@endpush

@push('css')
    <style>
        button#html5-qrcode-button-camera-stop {
            display: none !important;
        }
    </style>
@endpush


@push('scripts')
    <script>
        let table1;

        $(document).ready(function() {
            ScanQR();
        });

        table1 = $('.pengembalian-table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('pengembalian.data') }}',
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
                    data: 'nama_mahasiswa'
                },
                {
                    data: 'ruang'
                },
                {
                    data: 'pengembalian'
                },
            ]
        });

        function validasiForm() {
            var nim = $('[name=nim]').val();

            $.ajax({
                type: "POST",
                url: "{{ route('pengembalian.validasi') }}",
                data: {
                    "nim": $('[name=nim]').val(),
                },
                dataType: "json",
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 3000
                    }).then(() => {
                        window.location.href = "/admin/pengembalian/" + nim;
                    });
                },
                error: function(errors) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal!',
                        text: errors.responseJSON.message,
                        showConfirmButton: false,
                        timer: 3000
                    })

                }
            });
        }

        function ScanQR() {
            function onScanSuccess(decodedText, decodedResult) {
                // handle the scanned code as you like, for example:
                var nim = decodedText;
                html5QrcodeScanner.clear();

                $.ajax({
                    type: "POST",
                    url: "{{ route('pengembalian.validasi') }}",
                    data: {
                        "nim": nim,
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            window.location.href = "/admin/pengembalian/" + nim;
                            html5QrcodeScanner.render();
                            table1.ajax.reload();
                        });
                    },
                    error: function(errors) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Opps! Gagal!',
                            text: errors.responseJSON.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        html5QrcodeScanner.render();
                    }
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
    </script>
@endpush
