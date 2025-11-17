<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ekstrakurikuler;
use App\Models\Kegiatan;
use App\Models\AnggotaEkstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Redirect otomatis berdasarkan role.
     */
    public function index()
    {
        return redirect()->route(auth()->user()->getDashboardRoute());
    }

    /**
     * DASHBOARD SISWA
     */
    public function siswa()
    {
        $ekstrakurikulers = Ekstrakurikuler::with('pembina')->get();
        return view('siswa.index', compact('ekstrakurikulers'));
    }

    /**
     * DASHBOARD ADMIN — sekarang memakai statistik (card baru)
     */
    public function admin()
    {
        return view('admin.index', [
            'totalAdmin'      => User::where('role', 'admin')->count(),
            'totalPembina'    => User::where('role', 'pembina')->count(),
            'totalKetua'      => User::where('role', 'ketua')->count(),
            'totalSiswaRole'  => User::where('role', 'siswa')->count(),
            'totalEkskul'     => Ekstrakurikuler::count(),
            'totalSiswa'      => User::where('role', 'siswa')->count(),
            'totalPembina'    => User::where('role', 'pembina')->count(),
            'totalKetua'      => User::where('role', 'ketua')->count(),
            // 'totalKegiatan'   => Kegiatan::count(),
            'totalAnggota'    => AnggotaEkstrakurikuler::count(),
            // 'totalPrestasi'   => Kegiatan::where('tipe', 'prestasi')->count(),
        ]);
    }

    /**
     * DASHBOARD PEMBINA — sekarang dengan statistik
     */
    public function pembina()
    {
        $pembina = auth()->user();

        $ekstrakurikuler = $pembina->ekstrakurikulerDibina;

        if (!$ekstrakurikuler) {
            abort(403, 'Anda tidak menjadi pembina ekstrakurikuler.');
        }

        return view('pembina.index', [
            'ekstrakurikuler'  => $ekstrakurikuler,
            'anggotaAktif'     => $ekstrakurikuler->anggotaAktif()->count(),
            // 'totalKegiatan'    => $ekstrakurikuler->kegiatan->count(),
            // 'totalPrestasi'    => $ekstrakurikuler->kegiatan->where('tipe', 'prestasi')->count(),
            'totalAnggota'     => $ekstrakurikuler->anggota->count(),
        ]);
    }

    /**
     * DASHBOARD KETUA — sekarang dengan statistik lengkap
     */
    public function ketua()
    {
        $user = auth()->user();

        if ($user->role !== 'ketua') {
            abort(403, 'Anda bukan ketua ekstrakurikuler.');
        }

        $ekstrakurikuler = $user->ekstrakurikulerDipimpin;

        if (!$ekstrakurikuler) {
            abort(403, 'Anda belum terdaftar sebagai ketua di ekstrakurikuler manapun.');
        }

        return view('ketua.index', [
            'ekstrakurikuler'  => $ekstrakurikuler,
            'anggotaAktif'     => $ekstrakurikuler->anggotaAktif()->count(),
            'anggotaList'      => $ekstrakurikuler->anggotaAktif()->get(),
            // 'totalKegiatan'    => $ekstrakurikuler->kegiatan->count(),
            // 'totalPrestasi'    => $ekstrakurikuler->kegiatan->where('tipe', 'prestasi')->count(),
        ]);
    }
}
