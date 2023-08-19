<x-modal id="modal-detail" data-backdrop="static" data-keyboard="false" size="modal-md" class="peminjamanDetail">
    <x-slot name="title">
        Detail Form
    </x-slot>

    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped" id="detail">
                <thead>
                    <tr>
                        <th>Nama Alat</th>
                        <th>Keterangan Alat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="nama"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>
