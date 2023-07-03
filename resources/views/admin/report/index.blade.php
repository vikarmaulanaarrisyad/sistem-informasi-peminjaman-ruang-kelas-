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
                        <button data-toggle="modal" data-target="#modal-form" class="btn btn-sm btn-primary"><i
                                class="fas fa-pencil-alt"></i> Ubah Periode</button>

                        <a target="_blank" href="{{ route('report.export_pdf', compact('start', 'end')) }}"
                            class="btn btn-sm btn-danger"><i class="fas fa-file-pdf"></i> Export PDF</a>
                    </div>
                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <th width="5%">No</th>
                        <th>Hari / Tanggal</th>
                        <th>Mahasiswa</th>
                        <th>Nama Ruang</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Status</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    @include('admin.report.form')
@endsection

@includeIf('include.datatable')
@includeIf('include.datepicker')

@push('scripts')
    <script>
        let modal = '#modal-form';
        let table;

        table = $('.table').DataTable({
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
    </script>
@endpush
