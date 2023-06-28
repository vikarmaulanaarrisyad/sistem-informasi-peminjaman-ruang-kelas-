<?php

use App\Http\Controllers\{
    DashboardController,
    DosenController,
    JadwalController,
    KelasController,
    MahasiswaController,
    MatakuliahController,
    PeminjamanController,
    PerlengkapanController,
    RuangController,
    UserProfileInformationController
};
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

        //route kelas
        Route::get('ruang/data', [RuangController::class, 'data'])->name('ruang.data');
        Route::resource('ruang', RuangController::class)->except('create', 'edit');
        Route::get('ruang/{ruang}/detail', [RuangController::class, 'detail'])->name('ruang.detail');

        //route kelas
        Route::get('kelas/data', [KelasController::class, 'data'])->name('kelas.data');
        Route::resource('kelas', KelasController::class)->except('create', 'edit');
        Route::get('kelas/{kelas}/detail', [KelasController::class, 'detail'])->name('kelas.detail');

        //Route Matakuliah
        Route::get('matakuliah/data', [MatakuliahController::class, 'data'])->name('matakuliah.data');
        Route::resource('matakuliah', MatakuliahController::class)->except('create', 'edit');
        Route::get('matakuliah/{matakuliah}/detail', [MatakuliahController::class, 'detail'])->name('matakuliah.detail');

        //Route Jadwal
        Route::get('jadwal/data', [JadwalController::class, 'data'])->name('jadwal.data');
        Route::resource('jadwal', JadwalController::class)->except('create', 'edit');
        Route::get('jadwal/{jadwal}/detail', [JadwalController::class, 'detail'])->name('jadwal.detail');

        //Route peminjaman
        Route::get('peminjaman/data', [PeminjamanController::class, 'data'])->name('peminjaman.data');
        Route::resource('peminjaman', PeminjamanController::class);

        //Route perlengkapan
        Route::get('perlengkapan/data', [PerlengkapanController::class, 'data'])->name('perlengkapan.data');
        Route::resource('perlengkapan', PerlengkapanController::class)->except('create', 'edit');
        Route::get('perlengkapan/{perlengkapan}/detail', [PerlengkapanController::class, 'detail'])->name('perlengkapan.detail');
    });
    Route::group([
        'middleware' => 'role:mahasiswa',
        'prefix' => 'mahasiswa'
    ], function () {
        //Scanner

    });
});
