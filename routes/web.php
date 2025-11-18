<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\EkstrakurikulerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerlombaanController;
use App\Http\Controllers\KehadiranController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Route Utama (Public)
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', [TemplateController::class, 'index'])->name('home');

// Semua orang bisa melihat daftar anggota
Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');

// Semua orang juga bisa melihat daftar ekstrakurikuler
Route::get('/ekstrakurikuler', [EkstrakurikulerController::class, 'index'])->name('ekstrakurikuler.index');

// Daftar pembina ekstrakurikuler (opsional untuk publik)
Route::get('/ekstrakurikuler/pembina-list', [EkstrakurikulerController::class, 'getPembinaList'])
    ->name('ekstrakurikuler.pembina-list');

/*
|--------------------------------------------------------------------------
| Route Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    // CRUD Ekstrakurikuler hanya untuk admin
    Route::post('ekstrakurikuler', [EkstrakurikulerController::class, 'store'])->name('admin.ekstrakurikuler.store');
    Route::put('ekstrakurikuler/{id}', [EkstrakurikulerController::class, 'update'])->name('admin.ekstrakurikuler.update');
    Route::delete('ekstrakurikuler/{id}', [EkstrakurikulerController::class, 'destroy'])->name('admin.ekstrakurikuler.destroy');

    // Manajemen User
    Route::get('user', [UserController::class, 'index'])->name('admin.user.index');
    Route::post('user', [UserController::class, 'store'])->name('admin.user.store');
    Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('user/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('user/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');

    // **Modul Ratna**
    Route::resource('pendaftaran', PendaftaranController::class);
    Route::resource('pengumuman', PengumumanController::class);
    Route::resource('kegiatan', KegiatanController::class);
});

/*
|--------------------------------------------------------------------------
| Route Pembina
|--------------------------------------------------------------------------
*/
Route::prefix('pembina')->middleware(['auth', 'role:pembina'])->group(function () {
    Route::get('anggota', [AnggotaController::class, 'index'])->name('pembina.anggota.index');
    Route::post('anggota', [AnggotaController::class, 'store'])->name('pembina.anggota.store');
    Route::put('anggota/{id}', [AnggotaController::class, 'update'])->name('pembina.anggota.update');
    Route::delete('anggota/{id}', [AnggotaController::class, 'destroy'])->name('pembina.anggota.destroy');

    // CRUD Penilaian
    Route::resource('penilaian', PenilaianController::class)
        ->names('pembina.penilaian');

    // CRUD Perlombaan
    Route::resource('perlombaan', PerlombaanController::class)
        ->names('pembina.perlombaan');
    // CRUD Kehadiran
    Route::resource('kehadiran', KehadiranController::class)
        ->names('pembina.kehadiran');

});

Route::prefix('pembina')->middleware(['auth', 'role:pembina'])->name('pembina.')->group(function () {
    Route::get('penilaian', [\App\Http\Controllers\PenilaianController::class, 'index'])
        ->name('penilaian.index');
});


/*
|--------------------------------------------------------------------------
| Route Dashboard & Profil
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'admin'   => redirect()->route('dashboard.admin.index'),
            'pembina' => redirect()->route('dashboard.pembina.index'),
            'ketua'   => redirect()->route('dashboard.ketua.index'),
            default   => redirect()->route('dashboard.siswa.index'),
        };
    })->name('dashboard');

    // Dashboard per role
    Route::middleware('role:admin')->get('/admin', [DashboardController::class, 'admin'])
        ->name('dashboard.admin.index');

    Route::middleware('role:pembina')->get('/pembina', [DashboardController::class, 'pembina'])
        ->name('dashboard.pembina.index');

        Route::middleware('role:ketua')->get('/ketua', [DashboardController::class, 'ketua'])
        ->name('dashboard.ketua.index');
        
        Route::middleware('role:siswa')->get('/siswa', [DashboardController::class, 'siswa'])
        ->name('dashboard.siswa.index');
        
        // Profil
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
        Route::post('/profile/password/update', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
