<?php

use App\Http\Controllers\ProfileController;
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


Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
Route::get('/ekstrakurikuler', [EkstrakurikulerController::class, 'index'])->name('ekstrakurikuler.index');
Route::view('/visi-misi', 'siswa.visi_misi')->name('visi_misi.index');
Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
Route::get('/perlombaan', [PerlombaanController::class, 'index'])->name('perlombaan.index');
Route::get('/kehadiran', [KehadiranController::class, 'index'])->name('kehadiran.index');
Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
Route::get('/pengumuman', [PengumumanController::class, 'indexPublik'])->name('pengumuman.index');
// Route::get('/pengumuman/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/profile/pendaftaran', [PendaftaranController::class, 'index'])->name('profile.pendaftaran');
Route::get('/ekstrakurikuler/pembina-list', [EkstrakurikulerController::class, 'getPembinaList'])->name('ekstrakurikuler.pembina-list');
Route::post('/ketua/pendaftaran/{id}/approve', [PendaftaranApprovalController::class, 'ketuaApprove'])->name('ketua.pendaftaran.approve');
Route::post('/ketua/pendaftaran/{id}/reject', [PendaftaranApprovalController::class, 'ketuaReject'])->name('ketua.pendaftaran.reject');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::post('ekstrakurikuler', [EkstrakurikulerController::class, 'store'])->name('admin.ekstrakurikuler.store');
    Route::put('ekstrakurikuler/{id}', [EkstrakurikulerController::class, 'update'])->name('admin.ekstrakurikuler.update');
    Route::delete('ekstrakurikuler/{id}', [EkstrakurikulerController::class, 'destroy'])->name('admin.ekstrakurikuler.destroy');

    Route::get('user', [UserController::class, 'index'])->name('admin.user.index');
    Route::post('user', [UserController::class, 'store'])->name('admin.user.store');
    Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('user/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('user/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    Route::get('users/export/pdf', [UserController::class, 'exportPdf'])->name('admin.users.export.pdf');

    Route::resource('kegiatan', KegiatanController::class)->names('admin.kegiatan');

    Route::get('pengumuman', [PengumumanController::class, 'indexAdmin'])->name('admin.pengumuman.index');
    Route::get('pengumuman/create', [PengumumanController::class, 'create'])->name('admin.pengumuman.create');
    Route::post('pengumuman', [PengumumanController::class, 'store'])->name('admin.pengumuman.store');
    Route::get('pengumuman/{id}/edit', [PengumumanController::class, 'edit'])->name('admin.pengumuman.edit');
    Route::put('pengumuman/{id}', [PengumumanController::class, 'update'])->name('admin.pengumuman.update');
    Route::delete('pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('admin.pengumuman.destroy');
});

Route::prefix('pembina')->middleware(['auth', 'role:pembina'])->group(function () {
    Route::get('anggota', [AnggotaController::class, 'index'])->name('pembina.anggota.index');
    Route::post('anggota', [AnggotaController::class, 'store'])->name('pembina.anggota.store');
    Route::put('anggota/{id}', [AnggotaController::class, 'update'])->name('pembina.anggota.update');
    Route::delete('anggota/{id}', [AnggotaController::class, 'destroy'])->name('pembina.anggota.destroy');

    Route::get('penilaian', [PenilaianController::class, 'index'])->name('pembina.penilaian.index');
    Route::post('penilaian', [PenilaianController::class, 'store'])->name('pembina.penilaian.store');
    Route::put('penilaian/{id}', [PenilaianController::class, 'update'])->name('pembina.penilaian.update');
    Route::delete('penilaian/{id}', [PenilaianController::class, 'destroy'])->name('pembina.penilaian.destroy');

    Route::get('perlombaan', [PerlombaanController::class, 'index'])->name('pembina.perlombaan.index');
    Route::post('perlombaan', [PerlombaanController::class, 'store'])->name('pembina.perlombaan.store');
    Route::put('perlombaan/{id}', [PerlombaanController::class, 'update'])->name('pembina.perlombaan.update');
    Route::delete('perlombaan/{id}', [PerlombaanController::class, 'destroy'])->name('pembina.perlombaan.destroy');

    Route::get('kegiatan', [KegiatanController::class, 'index'])->name('pembina.kegiatan.index');
    Route::post('kegiatan', [KegiatanController::class, 'store'])->name('pembina.kegiatan.store');
    Route::put('kegiatan/{id}', [KegiatanController::class, 'update'])->name('pembina.kegiatan.update');
    Route::delete('kegiatan/{id}', [KegiatanController::class, 'destroy'])->name('pembina.kegiatan.destroy');

    Route::get('pengumuman', [PengumumanController::class, 'pembinaIndex'])->name('pembina.pengumuman.index');
    Route::get('pengumuman/create', [PengumumanController::class, 'pembinaCreate'])->name('pembina.pengumuman.create');
    Route::post('pengumuman', [PengumumanController::class, 'pembinaStore'])->name('pembina.pengumuman.store');
    Route::get('pengumuman/{id}/edit', [PengumumanController::class, 'pembinaEdit'])->name('pembina.pengumuman.edit');
    Route::put('pengumuman/{id}', [PengumumanController::class, 'pembinaUpdate'])->name('pembina.pengumuman.update');
    Route::delete('pengumuman/{id}', [PengumumanController::class, 'pembinaDestroy'])->name('pembina.pengumuman.destroy');

    Route::post('/ketua/pendaftaran/{id}/approve', [DashboardController::class, 'disetujui'])
    ->name('pendaftaran.approve');

    Route::post('/ketua/pendaftaran/{id}/reject', [DashboardController::class, 'reject'])
        ->name('pendaftaran.reject');

});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'admin'   => redirect()->route('dashboard.admin.index'),
            'pembina' => redirect()->route('dashboard.pembina.index'),
            'ketua'   => redirect()->route('dashboard.ketua.index'),
            default   => redirect()->route('dashboard.siswa.index'),
        };
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::post('/profile/password/update', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::middleware(['role:siswa'])->group(function () {
        Route::get('/profile/pendaftaran', [PendaftaranController::class, 'index'])->name('profile.pendaftaran');
        Route::get('/profile/pendaftaran/{id}', [PendaftaranController::class, 'show'])->name('profile.pendaftaran.show');
    });
});

Route::middleware('role:admin')->get('/admin', [DashboardController::class, 'admin'])->name('dashboard.admin.index');
Route::middleware('role:pembina')->get('/pembina', [DashboardController::class, 'pembina'])->name('dashboard.pembina.index');
Route::middleware('role:ketua')->get('/ketua', [DashboardController::class, 'ketua'])->name('dashboard.ketua.index');
Route::middleware('role:siswa')->get('/siswa', [DashboardController::class, 'siswa'])->name('dashboard.siswa.index');

require __DIR__ . '/auth.php';