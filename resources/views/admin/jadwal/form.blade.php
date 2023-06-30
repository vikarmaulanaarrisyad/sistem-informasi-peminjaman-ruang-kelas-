<x-modal data-backdrop="static" data-keyboard="false" size="modal-xl">
    <x-slot name="title">
        Tambah Daftar Matakuliah
    </x-slot>

    @method('POST')
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <label for="dosen">Pilih Dosen</label>
                <select name="dosen_id" id="dosen_id" class="form-control select2" style="width: 100%">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($daftarDosen as $dosen)
                        <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="matakuliah">Pilih Matkul</label>
                <select name="matakuliah_id" id="matakuliah_id" class="form-control select2" style="width: 100%">
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="kelas">Pilih Kelas</label>
                <select name="kelas_id" id="kelas_id" class="form-control select2" style="width: 100%">
                    <option disabled selected>Pilih salah satu</option>

                    {{-- @foreach ($daftarKelas as $kelas)
                        <option value="{{ $kelas->id }}">Kelas {{ $kelas->name }}</option>
                    @endforeach --}}
                </select>
            </div>
        </div>

    </div>

    <hr>

    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <label for="ruang">Pilih Ruang</label>
                <select name="ruang_id" id="ruang_id" class="form-control" style="width: 100%">
                    <option disabled selected>Pilih salah satu</option>
                    {{-- @foreach ($daftarRuang as $ruang)
                        <option value="{{ $ruang->id }}">{{ $ruang->name }}</option>
                    @endforeach --}}
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="waktu_mulai">Waktu Mulai</label>
                <div class="input-group time" id="waktu_mulai" data-target-input="nearest">
                    <input type="text" name="waktu_mulai" class="form-control datetimepicker-input"
                        data-target="#waktu_mulai" data-toggle="datetimepicker" />
                    <div class="input-group-append" data-target="#waktu_mulai" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-clock"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="waktu_selesai">Waktu Selesai</label>
                <div class="input-group time" id="waktu_selesai" data-target-input="nearest">
                    <input type="text" name="waktu_selesai" class="form-control datetimepicker-input"
                        data-target="#waktu_selesai" data-toggle="datetimepicker" />
                    <div class="input-group-append" data-target="#waktu_selesai" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-clock"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">

        <div class="col-lg-12">
            <div class="form-group">
                <label for="my-input">Pilih Hari</label>
                <div class="d-flex">
                    <div class="form-check ml-2">
                        <input class="form-check-input" type="checkbox" name="hari" id="hari" value="Senin">
                        <label class="form-check-label">Senin</label>
                    </div>
                    <div class="form-check ml-2">
                        <input class="form-check-input" type="checkbox" name="hari" id="hari" value="Selasa">
                        <label class="form-check-label">Selasa</label>
                    </div>
                    <div class="form-check ml-2">
                        <input class="form-check-input" type="checkbox" name="hari" id="hari" value="Rabu">
                        <label class="form-check-label">Rabu</label>
                    </div>
                    <div class="form-check ml-2">
                        <input class="form-check-input" type="checkbox" name="hari" id="hari" value="Kamis">
                        <label class="form-check-label">Kamis</label>
                    </div>
                    <div class="form-check ml-2">
                        <input class="form-check-input" type="checkbox" name="hari" id="hari" value="Jumat">
                        <label class="form-check-label">Jumat</label>
                    </div>
                    <div class="form-check ml-2">
                        <input class="form-check-input" type="checkbox" name="hari" id="hari"
                            value="Sabtu">
                        <label class="form-check-label">Sabtu</label>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-outline-primary"
            id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status"
                aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>
