<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ekstrakurikuler;
use App\Models\Perlombaan;
use App\Models\AnggotaEkstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $pembinas = $ekstrakurikulers->pluck('pembina')->flatten()->unique('id');

        return view('siswa.index', compact('ekstrakurikulers', 'pembinas'));
    }    

    /**
     * DASHBOARD ADMIN
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
            'totalAnggota'    => AnggotaEkstrakurikuler::count(),
        ]);
    }

    /**
     * DASHBOARD PEMBINA — gabungan dari DashboardPembinaController@index
     */
    public function pembina()
    {
        $pembina = auth()->user();

        $ekstrakurikulerList = Ekstrakurikuler::with(['ketua'])
            ->where('user_pembina_id', $pembina->id)
            ->get();

        if ($ekstrakurikulerList->isEmpty()) {
            abort(403, 'Anda tidak menjadi pembina ekstrakurikuler.');
        }

        $totalEkskul = $ekstrakurikulerList->count();
        $ekskulIds = $ekstrakurikulerList->pluck('id');

        $totalPerlombaan = Perlombaan::whereIn('ekstrakurikuler_id', $ekskulIds)->count();
        $perlombaanTahunIni = Perlombaan::whereIn('ekstrakurikuler_id', $ekskulIds)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();
            $anggotaIds = AnggotaEkstrakurikuler::whereIn('ekstrakurikuler_id', $ekskulIds)
            ->pluck('user_id');
        
        $anggotaList = User::whereIn('id', $anggotaIds)->get();
        $totalAnggota = $anggotaList->count();        
        $perlombaanTerbaru = Perlombaan::with(['ekstrakurikuler'])
            ->whereIn('ekstrakurikuler_id', $ekskulIds)
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        $tingkatSekolah       = Perlombaan::whereIn('ekstrakurikuler_id', $ekskulIds)->where('tingkat', 'Sekolah')->count();
        $tingkatKecamatan     = Perlombaan::whereIn('ekstrakurikuler_id', $ekskulIds)->where('tingkat', 'Kecamatan')->count();
        $tingkatKabupaten     = Perlombaan::whereIn('ekstrakurikuler_id', $ekskulIds)->where('tingkat', 'Kabupaten')->count();
        $tingkatProvinsi      = Perlombaan::whereIn('ekstrakurikuler_id', $ekskulIds)->where('tingkat', 'Provinsi')->count();
        $tingkatNasional      = Perlombaan::whereIn('ekstrakurikuler_id', $ekskulIds)->where('tingkat', 'Nasional')->count();
        $tingkatInternasional = Perlombaan::whereIn('ekstrakurikuler_id', $ekskulIds)->where('tingkat', 'Internasional')->count();

        return view('pembina.index', compact(
            'totalEkskul',
            'totalPerlombaan',
            'perlombaanTahunIni',
            'totalAnggota',
            'ekstrakurikulerList',
            'perlombaanTerbaru',
            'tingkatSekolah',
            'tingkatKecamatan',
            'tingkatKabupaten',
            'tingkatProvinsi',
            'tingkatNasional',
            'tingkatInternasional'
        ));
    }

    /**
     * DASHBOARD KETUA
     */
    public function ketua()
    {
        $ketuaId = Auth::id();
        $ekstrakurikuler = Ekstrakurikuler::with(['pembina'])
            ->where('user_ketua_id', $ketuaId)
            ->first();
            if ($ekstrakurikuler) {
            $ekskulId = $ekstrakurikuler->id;
            $ekskulId = $ekstrakurikuler->id;
            $anggotaIds = AnggotaEkstrakurikuler::where('ekstrakurikuler_id', $ekskulId)
                ->pluck('user_id');
            $anggotaList = User::whereIn('id', $anggotaIds)->get();
            $totalAnggota = $anggotaList->count();
            $totalPerlombaan = Perlombaan::where('ekstrakurikuler_id', $ekskulId)->count();
            $perlombaanTahunIni = Perlombaan::where('ekstrakurikuler_id', $ekskulId)
                ->whereYear('tanggal', Carbon::now()->year)
                ->count();

            $perlombaanTerbaru = Perlombaan::where('ekstrakurikuler_id', $ekskulId)
                ->orderBy('tanggal', 'desc')
                ->limit(5)
                ->get();

            $tingkatSekolah = Perlombaan::where('ekstrakurikuler_id', $ekskulId)
                ->where('tingkat', 'Sekolah')
                ->count();

            $tingkatKecamatan = Perlombaan::where('ekstrakurikuler_id', $ekskulId)
                ->where('tingkat', 'Kecamatan')
                ->count();

            $tingkatKabupaten = Perlombaan::where('ekstrakurikuler_id', $ekskulId)
                ->where('tingkat', 'Kabupaten')
                ->count();

            $tingkatProvinsi = Perlombaan::where('ekstrakurikuler_id', $ekskulId)
                ->where('tingkat', 'Provinsi')
                ->count();

            $tingkatNasional = Perlombaan::where('ekstrakurikuler_id', $ekskulId)
                ->where('tingkat', 'Nasional')
                ->count();

            $tingkatInternasional = Perlombaan::where('ekstrakurikuler_id', $ekskulId)
                ->where('tingkat', 'Internasional')
                ->count();
        } else {
            $totalAnggota = 0;
            $totalPerlombaan = 0;
            $perlombaanTahunIni = 0;
            $perlombaanTerbaru = collect();
            $tingkatSekolah = 0;
            $tingkatKecamatan = 0;
            $tingkatKabupaten = 0;
            $tingkatProvinsi = 0;
            $tingkatNasional = 0;
            $tingkatInternasional = 0;
        }

        return view('ketua.index', compact(
            'ekstrakurikuler',
            'totalAnggota',
            'totalPerlombaan',
            'perlombaanTahunIni',
            'perlombaanTerbaru',
            'tingkatSekolah',
            'tingkatKecamatan',
            'tingkatKabupaten',
            'tingkatProvinsi',
            'tingkatNasional',
            'tingkatInternasional'
        ));
    }
}