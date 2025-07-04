<?php

use App\Http\Controllers\Admin\AdminMainController;
use App\Http\Controllers\Admin\PetaController;
use App\Http\Controllers\Pemilik\PemilikMainController;
use App\Http\Controllers\Pemilik\KosController;
use App\Http\Controllers\Pengguna\PenggunaMainController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



Route::get('/register-pemilik', [AuthController::class, 'showRegisterPemilik'])->name('register.pemilik.form');
Route::post('/register-pemilik', [AuthController::class, 'registerPemilik'])->name('register.pemilik');


Route::get('/', [KosController::class, 'petaKos'])->name('beranda');
Route::get('/detailkos/{id}', [KosController::class, 'detailKos']);


//pengguna routes
Route::middleware(['auth', 'verified', 'rolemanager:pengguna'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/dashboard', [PenggunaMainController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [KosController::class, 'petaKosUser'])->name('dashboard');
        Route::get('/detailkos/{id}', [KosController::class, 'detailKosUser']);
        Route::get('/favorit', [PenggunaMainController::class, 'daftarFavorit'])->name('favorit.index');
        Route::post('/kos/{id}/favorit', [PenggunaMainController::class, 'tambahFavorit'])->name('kos.favorit');
        Route::post('/kos/{id}/unfavorit', [PenggunaMainController::class, 'hapusFavorit'])->name('kos.unfavorit');

        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit.user');
    });
});

//Admin routes
Route::middleware(['auth', 'verified', 'rolemanager:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminMainController::class, 'index'])->name('admin');

        //Kelola user
        Route::get('/verifikasi/pemilik', [AdminMainController::class, 'verifikasiPemilik'])->name('admin.verifikasi.pemilik');
        Route::patch('/verifikasi/pemilik/{id}', [AdminMainController::class, 'setujuiPemilik'])->name('admin.verifikasi.pemilik.setujui');
        Route::patch('/verifikasi/pemilik/{id}/tolak', [AdminMainController::class, 'tolakPemilik'])->name('admin.verifikasi.pemilik.tolak');

        Route::get('/admin/pemilik/disetujui', [AdminMainController::class, 'daftarPemilikDisetujui'])->name('admin.pemilik.disetujui');
        Route::delete('/admin/pemilik/{id}', [AdminMainController::class, 'hapusPemilik'])->name('admin.pemilik.destroy');

        Route::get('/daftar-kos', [AdminMainController::class, 'daftarKos'])->name('admin.daftarKos');
        Route::get('/daftar-pengguna', [AdminMainController::class, 'daftarPengguna'])->name('admin.daftarPengguna');
        Route::delete('/pengguna/{id}', [AdminMainController::class, 'hapusPengguna'])->name('admin.pengguna.destroy');

        // // Kelola Kos
        Route::get('/verifikasi-kos', [KosController::class, 'verifikasiKos'])->name('admin.verifikasi.kos');
        Route::post('/verifikasi-kos/{id}/setujui', [KosController::class, 'verifikasiKosdiSetujui']);
        Route::post('/verifikasi-kos/{id}/tolak', [KosController::class, 'verifikasiKosTolak']);

        // Kelola Peta / Layer
        Route::get('/peta', [PetaController::class, 'index'])->name('peta.index');
        Route::get('/peta/marker', [PetaController::class, 'marker'])->name('peta.marker');
        Route::get('/peta/upload', [PetaController::class, 'uploadForm'])->name('peta.upload.form');
        Route::post('/peta/upload', [PetaController::class, 'upload'])->name('peta.upload');
        Route::get('/peta/layer', [PetaController::class, 'layer'])->name('peta.layer');
        Route::get('/peta/layer_group', [PetaController::class, 'layer_group'])->name('peta.layer_group');


        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit.admin');
    });
});


// Route::middleware(['auth', 'verified', 'rolemanager:pemilik'])->prefix('pemilik')->group(function () {
Route::middleware(['auth', 'verified', 'rolemanager:pemilik', 'verifikasi.pemilik'])->prefix('pemilik')->group(function () {
    Route::get('/dashboard', [PemilikMainController::class, 'index'])->name('pemilik');
    Route::get('/kos/peta_kos', [KosController::class, 'peta_kos'])->name('kelolakos.peta_kos');

    Route::get('/kos/tambah_kos', [KosController::class, 'create'])->name('kelolakos.tambah_kos');
    Route::post('/kos/store', [KosController::class, 'store'])->name('kos.store');

    Route::get('/kos/daftar_kos', [KosController::class, 'daftar_kos'])->name('kelolakos.tampil_kos');

    Route::get('/kos/edit/{kos}', [KosController::class, 'edit'])->name('kelolakos.edit_kos');
    Route::put('/kos/update/{kos}', [KosController::class, 'update'])->name('kelolakos.update');
    Route::patch('/kos/ubah_status/{kos}', [KosController::class, 'ubahStatus'])->name('kelolakos.ubah_status');
    Route::delete('/kos/hapus/{kos}', [KosController::class, 'destroy'])->name('kelolakos.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit.pemilik');
});

// PATCH dan DELETE bisa disatukan
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

require __DIR__ . '/auth.php';
