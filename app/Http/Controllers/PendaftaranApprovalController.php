<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranApprovalController extends Controller
{
    /**
     * LIST PENDAFTARAN UNTUK PEMBINA
     */
    public function index()
    {
        $user = Auth::user();

        // Pembina hanya melihat pendaftar pada ekskul yang dia pegang
        $pendaftaran = Pendaftaran::with(['user', 'ekstrakurikuler'])
            ->whereHas('ekstrakurikuler', function ($query) use ($user) {
                $query->where('user_pembina_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pembina.pendaftaran.index', compact('pendaftaran'));
    }

    /**
     * SETUJUI PENDAFTARAN
     */
    public function approve($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        // keamanan: pastikan pembina ekskul ini
        if ($pendaftaran->ekstrakurikuler->user_pembina_id !== Auth::id()) {
            abort(403, 'Anda bukan pembina ekskul ini.');
        }

        $pendaftaran->update([
            'status' => 'disetujui',
            'disetujui_oleh' => Auth::id(),
            'tanggal_disetujui' => now(),
        ]);

        return back()->with('success', 'Pendaftaran berhasil disetujui!');
    }

    /**
     * TOLAK PENDAFTARAN
     */
    public function reject($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        // keamanan: pastikan pembina ekskul ini
        if ($pendaftaran->ekstrakurikuler->user_pembina_id !== Auth::id()) {
            abort(403, 'Anda bukan pembina ekskul ini.');
        }

        $pendaftaran->update([
            'status' => 'ditolak',
            'disetujui_oleh' => Auth::id(),
            'tanggal_disetujui' => now(),
        ]);

        return back()->with('success', 'Pendaftaran ditolak.');
    }
}