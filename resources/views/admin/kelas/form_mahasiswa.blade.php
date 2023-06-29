<x-modal data-backdrop="static" data-keyboard="false" size="modal-md">
    <x-slot name="title">
        Tambah Daftar Mahasiswa
    </x-slot>

    <form id="form-mahasiswa">
        @csrf

        <input type="hidden" id="kelas_id" value="{{ $kelas->id }}">

        <div class="row">
            <div class="col-md-12">
                <x-table class="table-mahasiswa" style="width: 100%">
                    <x-slot name="thead">
                        <tr>
                            <th style="width: 10%">NO</th>
                            <th style="width: 5%">
                                <input type="checkbox" name="select_all[]" id="select_all" class="select_all">
                            </th>
                            <th style="width: 80px">NIM</th>
                            <th style="width: 100px">NAMA</th>
                        </tr>
                    </x-slot>
                </x-table>
            </div>
        </div>

        <x-slot name="footer">
            <button type="button" onclick="submitForm('{{ route('kelas.mahasiswa.store') }}', '{{ $kelas->id }}')"
                class="btn btn-sm btn-outline-primary" id="submitBtn">
                <span id="spinner-border" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <i class="fas fa-save mr-1"></i>
                Simpan</button>
            <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-times"></i>
                Close
            </button>
        </x-slot>
    </form>
</x-modal>
