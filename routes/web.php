<?php

use App\Http\Controllers\{
    DashboardController,
    DosenController,
    JadwalController,
    JadwalMahasiswaController,
    KelasController,
    MahasiswaController,
    MatakuliahController,
    PeminjamanController,
    PengembalianController,
    PerlengkapanController,
    QrCodeController,
    ReportController,
    RuangController,
    SettingController,
    UserProfileInformationController
};
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::group([
    'middleware' => ['auth', 'role:admin,mahasiswa'],
], function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/user/profile/password', [UserProfileInformationController::class, 'showPassword'])
        ->name('profile.show.password');


    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        return 'Storage Success';
    });
    Route::get('/route-cache', function () {
        Artisan::call('route:cache');
        return 'Route cache cleared! <br> Routes cached successfully!';
    });


    Route::group([
        'middleware' => 'role:admin',
        'prefix' => 'admin'
    ], function () {
        // route mahasiswa
        Route::get('mahasiswa/data', [MahasiswaController::class, 'data'])->name('mahasiswa.data');
        Route::get('mahasiswa/{mahaiswa}/detail', [MahasiswaController::class, 'detail'])->name('mahasiswa.detail');
        Route::resource('mahasiswa', MahasiswaController::class)->except('create', 'edit', 'destroy', 'update', 'show');

        //route dosen
        Route::get('dosen/data', [DosenController::class, 'data'])->name('dosen.data');
        Route::resource('dosen', DosenController::class)->except('create', 'edit');
        Route::get('dosen/{dosen}/detail', [DosenController::class, 'detail'])->name('dosen.detail');
        Route::get('dosen/{dosen_id}/matakuliah', [DosenController::class, 'dosenMatakuliah'])->name('dosen.matakuliah.index');
        Route::get('dosen/{dosen}/matakuliah/data', [DosenController::class, 'matakuliahData'])->name('dosen.matakuliah.data');
        Route::post('dosen/matakuliah/store', [DosenController::class, 'dosenMatakuliahStore'])->name('dosen.matakuliah.store');
        Route::get('dosen/{dosen_id}/get_matakuliah_dosen', [DosenController::class, 'getDosenMatakuliah'])->name('dosen.get_matakuliah_dosen');
        Route::delete('dosen/matakuliah/{matakuliah_id}/destroy', [DosenController::class, 'matakuliahDestroy'])->name('dosen.matakuliah_destroy');

        //route kelas
        Route::get('ruang/data', [RuangController::class, 'data'])->name('ruang.data');
        Route::resource('ruang', RuangController::class)->except('create', 'edit');
        Route::get('ruang/{ruang}/detail', [RuangController::class, 'detail'])->name('ruang.detail');

        /* ROUTE KELAS */
        Route::get('kelas/data', [KelasController::class, 'data'])->name('kelas.data');
        Route::resource('kelas', KelasController::class)->except('create', 'edit');
        Route::get('kelas/{kelas}/detail', [KelasController::class, 'detail'])->name('kelas.detail');

        //route kelas mahasiswa
        Route::get('kelas/mahasiswa/data', [KelasController::class, 'mahasiswaData'])->name('kelas.mahasiswa.data');
        Route::get('kelas/{kelas_id}/mahasiswa', [KelasController::class, 'createFormMahasiswa'])->name('kelas.form_mahasiswa');
        Route::post('kelas/add_mahasiswa', [KelasController::class, 'mahasiswaStore'])->name('kelas.mahasiswa.store');
        Route::get('kelas/{kelas_id}/get_kelas_mahasiswa', [KelasController::class, 'getKelasMahasiswa'])->name('kelas.get_kelas_mahasiswa');
        Route::delete('kelas/mahasiswa/{mahasiswa_id}/destroy', [KelasController::class, 'mahasiswaDestroy'])->name('kelas.mahasiswa_destroy');

        //route kelas matakuliah
        Route::get('kelas/matakuliah/data', [KelasController::class, 'matakuliahData'])->name('kelas.matakuliah.data');
        Route::get('kelas/{kelas_id}/matakuliah', [KelasController::class, 'kelasMatakuliahIndex'])->name('kelas.matakuliah.index');
        Route::post('kelas/add_matakuliah', [KelasController::class, 'matakuliahStore'])->name('kelas.matakuliah.store');
        Route::get('kelas/{kelas_id}/get_kelas_matakuliah', [KelasController::class, 'getKelasmatakuliah'])->name('kelas.get_kelas_matakuliah');
        Route::delete('kelas/matakuliah/{matakuliah_id}/destroy', [KelasController::class, 'matakuliahDestroy'])->name('kelas.matakuliah_destroy');
        /* END ROUTE KELAS */

        //Route Matakuliah
        Route::get('matakuliah/data', [MatakuliahController::class, 'data'])->name('matakuliah.data');
        Route::resource('matakuliah', MatakuliahController::class)->except('create', 'edit');
        Route::get('matakuliah/{matakuliah}/detail', [MatakuliahController::class, 'detail'])->name('matakuliah.detail');

        /* ROUTE JADWAL */

        Route::get('jadwal/data', [JadwalController::class, 'data'])->name('jadwal.data');
        Route::get('jadwal/data_jadwal', [JadwalController::class, 'data2'])->name('jadwal.data_jadwal');
        Route::get('jadwal/view', [JadwalController::class, 'view'])->name('jadwal.view');
        Route::resource('jadwal', JadwalController::class)->except('edit');
        Route::get('jadwal/{jadwal}/detail', [JadwalController::class, 'detail'])->name('jadwal.detail');

        Route::post('jadwal/dosen/data', [JadwalController::class, 'getDataMatakuliah'])->name('jadwal.dosen.data');

        /* END ROUTE JADWAL */

        //Route peminjaman
        Route::get('peminjaman/data', [PeminjamanController::class, 'data'])->name('peminjaman.data');
        Route::get('peminjaman/{id}detail',[PeminjamanController::class, 'detail'])->name('peminjaman.detail');
        Route::resource('peminjaman', PeminjamanController::class);

        //Route perlengkapan
        Route::get('perlengkapan/data', [PerlengkapanController::class, 'data'])->name('perlengkapan.data');
        Route::resource('perlengkapan', PerlengkapanController::class)->except('create', 'edit');
        Route::get('perlengkapan/{perlengkapan}/detail', [PerlengkapanController::class, 'detail'])->name('perlengkapan.detail');

        Route::get('pengembalian/data', [PengembalianController::class, 'data'])->name('pengembalian.data');
        Route::post('pengembalian/validasi', [PengembalianController::class, 'validasi'])->name('pengembalian.validasi');
        Route::resource('pengembalian', PengembalianController::class)->except('edit', 'create');

        Route::resource('setting', SettingController::class);

        Route::get('/report', [ReportController::class, 'index'])->name('report.index');
        Route::get('/report/data/{start}/{end}', [ReportController::class, 'data'])->name('report.data');
        Route::get('/report/pdf/{start}/{end}', [ReportController::class, 'exportPDF'])->name('report.export_pdf');

    });
    Route::group([
        'middleware' => 'role:mahasiswa',
        'prefix' => 'mahasiswa'
    ], function () {
        //Scanner
        Route::get('/jadwal', [JadwalMahasiswaController::class, 'index'])->name('mahasiswa.jadwal.index');
        Route::get('/jadwal/data', [JadwalMahasiswaController::class, 'data'])->name('mahasiswa.jadwal.data');
        Route::get('/qrcode/download/{nim}', [QrCodeController::class, 'download'])->name('qrcode.download');
    });
});
