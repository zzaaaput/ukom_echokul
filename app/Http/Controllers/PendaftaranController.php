<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    // Daftar pendaftaran siswa login
    public function index()
    {
        // Ambil pendaftaran hanya milik siswa yang login
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->latest()->get();

        // Blade berada di resources/views/profile/pendaftaran.blade.php
        return view('profile.pendaftaran', compact('pendaftaran'));
    }

    // Halaman buat pendaftaran baru (jika dibutuhkan)
    public function create()
    {
        return view('pendaftaran.create');
    }

    // Simpan data pendaftaran baru
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

        if ($request->hasFile('surat_keterangan_ortu')) {
            $data['surat_keterangan_ortu'] = $request->file('surat_keterangan_ortu')->store('surat_keterangan', 'public');
        }

        Pendaftaran::create($data);

        return redirect()->route('profile.pendaftaran')->with('success', 'Pendaftaran berhasil dikirim.');
    }

    // Detail pendaftaran siswa login
    public function show($id)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->findOrFail($id);

        // Blade berada di resources/views/profile/pendaftaran_show.blade.php
        return view('profile.pendaftaran_show', compact('pendaftaran'));
    }

    // Edit & update untuk siswa (opsional, jika dibutuhkan)
    public function edit($id)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->findOrFail($id);
        return view('pendaftaran.edit', compact('pendaftaran'));
    }

    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikulers,id',
            'surat_keterangan_ortu' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('surat_keterangan_ortu')) {
            $pendaftaran->surat_keterangan_ortu = $request->file('surat_keterangan_ortu')->store('surat_keterangan', 'public');
        }

        $pendaftaran->ekstrakurikuler_id = $request->ekstrakurikuler_id;
        $pendaftaran->save();

        return redirect()->route('profile.pendaftaran')->with('success', 'Pendaftaran berhasil diperbarui.');
    }

    // Hapus pendaftaran siswa (opsional)
    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->findOrFail($id);
        $pendaftaran->delete();

        return redirect()->route('profile.pendaftaran')->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
