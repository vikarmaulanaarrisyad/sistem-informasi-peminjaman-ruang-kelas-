<div id="modal-detail" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <div id="reader" width="600px"></div>
                </div>
            </div>
            <div class="modal-footer">
                <p>Silahkan lakukan scan QR Code</p>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
@endpush
