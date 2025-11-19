<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pendaftaran = $user->pendaftarans()->with('ekstrakurikuler')->latest()->get();
        return view('profil.pendaftaran.index', compact('pendaftaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikuler,id',
            'surat_keterangan_ortu' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'alasan' => 'nullable|string'
        ]);

        $filePath = null;

        if ($request->hasFile('surat_keterangan_ortu')) {
            $filePath = $request->file('surat_keterangan_ortu')->store('surat_ortu', 'public');
        }

        Pendaftaran::create([
            'user_id' => auth()->id(),
            'ekstrakurikuler_id' => $request->ekstrakurikuler_id,
            'tanggal_daftar' => now()->toDateString(),
            'alasan' => $request->alasan,
            'surat_keterangan_ortu' => $filePath,
            'status' => 'menunggu',
        ]);

        return back()->with('success', 'Pendaftaran berhasil dikirim!');
    }

}