<x-modal data-backdrop="static" data-keyboard="false" size="modal-md">
    <x-slot name="title">
        Tambah Daftar Matakuliah
    </x-slot>

    <form id="form-matakuliah">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <x-table class="matakuliah-table" style="width: 100%">
                    <x-slot name="thead">
                        <tr>
                            <th>NO</th>
                            <th>
                                <input type="checkbox" name="select_all[]" id="select_all" class="select_all">
                            </th>
                            <th>MATAKULIAH</th>
                        </tr>
                    </x-slot>
                </x-table>
            </div>
        </div>

        <x-slot name="footer">
            <button type="button" onclick="submitForm('{{ route('dosen.matakuliah.store') }}', '{{ $dosen->id }}')"
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
