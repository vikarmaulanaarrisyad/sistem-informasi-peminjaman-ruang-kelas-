@extends('layouts.app')

@section('title', 'Laporan Peminjaman Alat ' . tanggal_indonesia($start) . ' s/d ' . tanggal_indonesia($end))
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <div class="btn-group">
                        <button onclick="ubahPeriode()" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Ubah
                            Periode</button>

                        <a target="_blank" href="{{ route('report.export_pdf', compact('start', 'end')) }}"
                            class="btn btn-sm btn-danger"><i class="fas fa-file-pdf"></i> Export PDF</a>
                    </div>
                </x-slot>

                <x-table class="laporan">
                    <x-slot name="thead">
                        <th width="5%">No</th>
                        <th>Hari / Tanggal</th>
                        <th>Mahasiswa</th>
                        <th>Nama Ruang</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    @includeIf('admin.report.form')
    @include('admin.report.modal')
@endsection

@includeIf('include.datatable')
@includeIf('include.datepicker')

@push('scripts')
    <script>
        let modal = '#modal-periode';
        let modalDetail = '#modal-detail';
        let table, tabl2;

        table = $('.laporan').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('report.data', compact('start', 'end')) }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'tanggal',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'mahasiswa',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'ruang',
                    searchable: false,
                    sortable: false,
                },
                {
                    data: 'jammulai',
                    searchable: false,
                    sortable: false,
                },
                {
                    data: 'jamselesai',
                    searchable: false,
                    sortable: false,
                },
                {
                    data: 'status',
                    searchable: false,
                    sortable: false,
                },
                {
                    data: 'aksi',
                    searchable: false,
                    sortable: false,
                },
            ],
            paginate: false,
            searching: false,
            bInfo: false,
            order: []
        });

        function deleteData(url) {
            if (confirm('Yakin data akan dihapus?')) {
                $.post(url, {
                        '_method': 'delete'
                    })
                    .done(response => {
                        showAlert(response.message, 'success');
                        table.ajax.reload();
                    })
                    .fail(errors => {
                        showAlert('Tidak dapat menghapus data');
                        return;
                    });
            }
        }

        function ubahPeriode() {
            $(`${modal}`).modal('show');
        }

        function detailForm(url, title) {
            $.get(url)
                .done(response => {
                    console.log(response);

                    // Menampilkan modal
                    $(modalDetail).modal('show');
                    $(`${modalDetail} .modal-title`).text('Detail Ruang ' + title);

                    // Mengisi tabel dengan informasi perlengkapan
                    const perlengkapanTable = $('#detail tbody');
                    perlengkapanTable.empty();

                    response.data[0].perlengkapan.forEach(item => {
                        perlengkapanTable.append(`
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.keterangan}</td>
                    </tr>
                `);
                    });
                });
        }
    </script>
@endpush
