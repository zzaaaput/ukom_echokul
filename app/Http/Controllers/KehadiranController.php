<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Kegiatan;
use App\Models\AnggotaEkstrakurikuler;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KehadiranController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Pembina hanya bisa mengelola ekskul binaannya
        $ekskul_binaan = Ekstrakurikuler::where('user_pembina_id', $user->id)->first();

        $search = $request->search;

        $kehadiran = Kehadiran::with(['anggota.user', 'kegiatan'])
            ->when($search, function ($q) use ($search) {

                // FIX: Grouping agar query tidak error
                $q->where(function ($sub) use ($search) {
                    $sub->whereHas('anggota.user', function ($u) use ($search) {
                        $u->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('kegiatan', function ($ka) use ($search) {
                        $ka->where('nama_kegiatan', 'like', "%$search%");
                    });
                });

            })
            ->orderBy('tanggal', 'desc')
            ->paginate(10)  // INI TIDAK ERROR LAGI
            ->withQueryString();

        $anggota = AnggotaEkstrakurikuler::with('user')->get();
        $kegiatan = Kegiatan::orderBy('tanggal', 'desc')->get();

        return view('pembina.kehadiran.index', compact(
            'kehadiran',
            'anggota',
            'kegiatan',
            'ekskul_binaan'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_ekskul_id' => 'required',
            'kegiatan_id'       => 'required',
            'tanggal'           => 'required|date',
            'status'            => 'required',
            'bukti_kehadiran'   => 'nullable|image|max:2048',
        ]);

        $foto = $request->hasFile('bukti_kehadiran')
            ? $request->file('bukti_kehadiran')->store('kehadiran', 'public')
            : null;

        Kehadiran::create([
            'anggota_ekskul_id' => $request->anggota_ekskul_id,
            'kegiatan_id'       => $request->kegiatan_id,
            'tanggal'           => $request->tanggal,
            'status'            => $request->status,
            'bukti_kehadiran'   => $foto,
            'dicatat_oleh'      => Auth::id(),
        ]);

        return back()->with('success', 'Kehadiran berhasil dicatat');
    }

    public function update(Request $request, $id)
    {
        $kehadiran = Kehadiran::findOrFail($id);

        $request->validate([
            'anggota_ekskul_id' => 'required',
            'kegiatan_id'       => 'required',
            'tanggal'           => 'required|date',
            'status'            => 'required',
            'bukti_kehadiran'   => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('bukti_kehadiran')) {
            $kehadiran->bukti_kehadiran = $request->file('bukti_kehadiran')->store('kehadiran', 'public');
        }

        $kehadiran->update([
            'anggota_ekskul_id' => $request->anggota_ekskul_id,
            'kegiatan_id'       => $request->kegiatan_id,
            'tanggal'           => $request->tanggal,
            'status'            => $request->status,
        ]);

        return back()->with('success', 'Kehadiran berhasil diperbarui');
    }

    public function destroy($id)
    {
        Kehadiran::findOrFail($id)->delete();
        return back()->with('success', 'Kehadiran berhasil dihapus');
    }
}
