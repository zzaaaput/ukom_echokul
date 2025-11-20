<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{
    /**
     * Daftar pendaftaran siswa login
     */
    public function index()
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('profile.pendaftaran', compact('pendaftaran'));
    }

    /**
     * Form membuat pendaftaran baru
     */
    public function create()
    {
        return view('pendaftaran.create');
    }

    /**
     * Simpan data pendaftaran
     */
    public function store(Request $request)
    {
        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikuler,id',
            'alasan' => 'nullable|string',
            'surat_keterangan_ortu' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $data = [
            'user_id' => Auth::id(),
            'ekstrakurikuler_id' => $request->ekstrakurikuler_id,
            'alasan' => $request->alasan,
            'status' => 'menunggu',
            'tanggal_daftar' => now(),
        ];

        // Simpan file ke storage/images/pendaftaran
        if ($request->hasFile('surat_keterangan_ortu')) {
            $data['surat_keterangan_ortu'] = 
                $request->file('surat_keterangan_ortu')->store('images/pendaftaran', 'public');
        }

        Pendaftaran::create($data);

        return redirect()->route('profile.pendaftaran')
            ->with('success', 'Pendaftaran berhasil dikirim.');
    }

    /**
     * Detail pendaftaran
     */
    public function show($id)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('profile.pendaftaran_show', compact('pendaftaran'));
    }

    /**
     * Edit
     */
    public function edit($id)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pendaftaran.edit', compact('pendaftaran'));
    }

    /**
     * Update data pendaftaran
     */
    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikuler,id',
            'surat_keterangan_ortu' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Jika ada file baru → hapus file lama
        if ($request->hasFile('surat_keterangan_ortu')) {

            if ($pendaftaran->surat_keterangan_ortu && 
                Storage::disk('public')->exists($pendaftaran->surat_keterangan_ortu)) {
                Storage::disk('public')->delete($pendaftaran->surat_keterangan_ortu);
            }

            $pendaftaran->surat_keterangan_ortu =
                $request->file('surat_keterangan_ortu')->store('images/pendaftaran', 'public');
        }

        $pendaftaran->ekstrakurikuler_id = $request->ekstrakurikuler_id;
        $pendaftaran->save();

        return redirect()->route('profile.pendaftaran')
            ->with('success', 'Pendaftaran berhasil diperbarui.');
    }

    /**
     * Hapus pendaftaran
     */
    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())
            ->findOrFail($id);

        // hapus file surat jika ada
        if ($pendaftaran->surat_keterangan_ortu &&
            Storage::disk('public')->exists($pendaftaran->surat_keterangan_ortu)) {
            Storage::disk('public')->delete($pendaftaran->surat_keterangan_ortu);
        }

        $pendaftaran->delete();

        return redirect()->route('profile.pendaftaran')
            ->with('success', 'Pendaftaran berhasil dihapus.');
    }
}