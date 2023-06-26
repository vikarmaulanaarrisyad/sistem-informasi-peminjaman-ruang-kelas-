<?php

use App\Http\Controllers\{
    DashboardController,
    DosenController,
    KelasController,
    MahasiswaController,
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
        Route::resource('mahasiswa', MahasiswaController::class)->except('create', 'edit', 'destroy', 'update','show');

        //route dosen
        Route::get('dosen/data', [DosenController::class, 'data'])->name('dosen.data');
        Route::resource('dosen', DosenController::class)->except('create','edit');
        Route::get('dosen/{dosen}/detail', [DosenController::class, 'detail'])->name('dosen.detail');

        //route kelas
        Route::get('kelas/data', [KelasController::class, 'data'])->name('kelas.data');
        Route::resource('kelas', KelasController::class)->except('create', 'edit');
        Route::get('kelas/{kelas}/detail', [KelasController::class, 'detail'])->name('kelas.detail');

    });
    Route::group([
        'middleware' => 'role:mahasiswa',
        'prefix' => 'mahasiswa'
    ], function () {
        //Scanner

    });
});
