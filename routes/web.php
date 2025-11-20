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
use App\Http\Controllers\PendaftaranApprovalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Route Utama (Public)
|--------------------------------------------------------------------------
*/
Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
Route::get('/ekstrakurikuler', [EkstrakurikulerController::class, 'index'])->name('ekstrakurikuler.index');
Route::view('/visi-misi', 'siswa.visi_misi')->name('visi_misi.index');
Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
Route::get('/perlombaan', [PerlombaanController::class, 'index'])->name('perlombaan.index');
Route::get('/kehadiran', [KehadiranController::class, 'index'])->name('kehadiran.index');
Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/profile/pendaftaran', [PendaftaranController::class, 'index'])->name('profile.pendaftaran');

Route::get('/ekstrakurikuler/pembina-list', [EkstrakurikulerController::class, 'getPembinaList'])
    ->name('ekstrakurikuler.pembina-list');

/*
|--------------------------------------------------------------------------
| Route Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // CRUD Ekstrakurikuler
    Route::post('ekstrakurikuler', [EkstrakurikulerController::class, 'store'])->name('admin.ekstrakurikuler.store');
    Route::put('ekstrakurikuler/{id}', [EkstrakurikulerController::class, 'update'])->name('admin.ekstrakurikuler.update');
    Route::delete('ekstrakurikuler/{id}', [EkstrakurikulerController::class, 'destroy'])->name('admin.ekstrakurikuler.destroy');

    // Manajemen User
    Route::get('user', [UserController::class, 'index'])->name('admin.user.index');
    Route::post('user', [UserController::class, 'store'])->name('admin.user.store');
    Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('user/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('user/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    Route::get('users/export/pdf', [UserController::class, 'exportPdf'])->name('admin.users.export.pdf');

    // Modul Ratna
    Route::resource('pengumuman', PengumumanController::class);
    Route::resource('kegiatan', KegiatanController::class);

    // Pengumuman
    Route::get('pengumuman', [PengumumanController::class, 'index'])->name('admin.pengumuman.index');
    Route::post('pengumuman', [PengumumanController::class, 'store'])->name('admin.pengumuman.store');
    Route::put('pengumuman/{id}', [PengumumanController::class, 'update'])->name('admin.pengumuman.update');
    Route::delete('pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('admin.pengumuman.destroy');

});

/*
|--------------------------------------------------------------------------
| Route Pembina
|--------------------------------------------------------------------------
*/
Route::prefix('pembina')->middleware(['auth', 'role:pembina'])->group(function () {
    // Anggota
    Route::get('anggota', [AnggotaController::class, 'index'])->name('pembina.anggota.index');
    Route::post('anggota', [AnggotaController::class, 'store'])->name('pembina.anggota.store');
    Route::put('anggota/{id}', [AnggotaController::class, 'update'])->name('pembina.anggota.update');
    Route::delete('anggota/{id}', [AnggotaController::class, 'destroy'])->name('pembina.anggota.destroy');

    // Penilaian
    Route::get('penilaian', [PenilaianController::class, 'index'])->name('pembina.penilaian.index');
    Route::post('penilaian', [PenilaianController::class, 'store'])->name('pembina.penilaian.store');
    Route::put('penilaian/{id}', [PenilaianController::class, 'update'])->name('pembina.penilaian.update');
    Route::delete('penilaian/{id}', [PenilaianController::class, 'destroy'])->name('pembina.penilaian.destroy');

    // Perlombaan
    Route::get('perlombaan', [PerlombaanController::class, 'index'])->name('pembina.perlombaan.index');
    Route::post('perlombaan', [PerlombaanController::class, 'store'])->name('pembina.perlombaan.store');
    Route::put('perlombaan/{id}', [PerlombaanController::class, 'update'])->name('pembina.perlombaan.update');
    Route::delete('perlombaan/{id}', [PerlombaanController::class, 'destroy'])->name('pembina.perlombaan.destroy');

    // Kegiatan
    Route::get('kegiatan', [KegiatanController::class, 'index'])->name('pembina.kegiatan.index');
    Route::post('kegiatan', [KegiatanController::class, 'store'])->name('pembina.kegiatan.store');
    Route::put('kegiatan/{id}', [KegiatanController::class, 'update'])->name('pembina.kegiatan.update');
    Route::delete('kegiatan/{id}', [KegiatanController::class, 'destroy'])->name('pembina.kegiatan.destroy');

    // Pendaftaran approval
    Route::get('/pendaftaran', [PendaftaranApprovalController::class, 'index'])->name('pendaftaran.index');
    Route::post('/pendaftaran/{pendaftaran}/approve', [PendaftaranApprovalController::class, 'approve'])->name('pendaftaran.approve');
    Route::post('/pendaftaran/{pendaftaran}/reject', [PendaftaranApprovalController::class, 'reject'])->name('pendaftaran.reject');
});

/*
|--------------------------------------------------------------------------
| Route Dashboard & Profil
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'admin'   => redirect()->route('dashboard.admin.index'),
            'pembina' => redirect()->route('dashboard.pembina.index'),
            'ketua'   => redirect()->route('dashboard.ketua.index'),
            default   => redirect()->route('dashboard.siswa.index'),
        }; 
    })->name('dashboard');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::post('/profile/password/update', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Pendaftaran siswa
    Route::middleware(['role:siswa'])->group(function () {
        Route::get('/profile/pendaftaran', [PendaftaranController::class, 'index'])->name('profile.pendaftaran');
        Route::get('/profile/pendaftaran/{id}', [PendaftaranController::class, 'show'])->name('profile.pendaftaran.show');
    });
});

// Dashboard per role
Route::middleware('role:admin')->get('/admin', [DashboardController::class, 'admin'])->name('dashboard.admin.index');
Route::middleware('role:pembina')->get('/pembina', [DashboardController::class, 'pembina'])->name('dashboard.pembina.index');
Route::middleware('role:ketua')->get('/ketua', [DashboardController::class, 'ketua'])->name('dashboard.ketua.index');
Route::middleware('role:siswa')->get('/siswa', [DashboardController::class, 'siswa'])->name('dashboard.siswa.index');

// Route khusus siswa untuk pengumuman
Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
});


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
