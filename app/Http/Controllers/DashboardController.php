<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect()->route(auth()->user()->getDashboardRoute());
    }

    public function siswa()
    {
        $ekstrakurikulers = Ekstrakurikuler::with('pembina')->get();
        return view('siswa.index', compact('ekstrakurikulers'));
    }

    public function admin()
    {
        return view('admin.index');
    }

    public function pembina()
    {
        $pembina = auth()->user();
        $ekstrakurikuler = auth()->user()->ekstrakurikulerDibina;
        if (!$ekstrakurikuler) {
            abort(403, 'Anda tidak menjadi pembina ekstrakurikuler.');
        }

        $anggotaAktif = $ekstrakurikuler->anggotaAktif()->get();

        return view('pembina.index', compact('ekstrakurikuler', 'anggotaAktif'));
    }

    public function ketua()
    {
        $user = auth()->user();

        // Pastikan user memang berperan sebagai ketua
        if ($user->role !== 'ketua') {
            abort(403, 'Anda bukan ketua ekstrakurikuler.');
        }

        // Ambil ekstrakurikuler yang dipimpin user ini
        $ekstrakurikuler = $user->ekstrakurikulerDipimpin;

        if (!$ekstrakurikuler) {
            abort(403, 'Anda belum terdaftar sebagai ketua di ekstrakurikuler manapun.');
        }

        // Ambil daftar anggota aktif
        $anggotaList = $ekstrakurikuler->anggotaAktif()->get();

        return view('ketua.index', compact('ekstrakurikuler', 'anggotaList'));
    }

}