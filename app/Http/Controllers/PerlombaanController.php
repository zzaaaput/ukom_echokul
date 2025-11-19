<?php

namespace App\Http\Controllers;

use App\Models\Perlombaan;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerlombaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        // Query dasar
        $query = Perlombaan::with('ekstrakurikuler')
            ->orderBy('tanggal', 'desc');

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($search) {
                $q->where('nama_perlombaan', 'like', "%{$search}%")
                  ->orWhere('tempat', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('tingkat', 'like', "%{$search}%")
                  ->orWhere('tahun_ajaran', 'like', "%{$search}%");
            });
        }

        // Filter ekstrakurikuler dari dropdown (optional)
        if ($request->filled('ekskul')) {
            $query->where('ekstrakurikuler_id', $request->ekskul);
        }

        // Filter tingkat dari dropdown (optional)
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        // Pagination
        $perlombaan = $query->paginate(10)->withQueryString();

        // Data statistik
        $totalPerlombaan = Perlombaan::count();
        $totalEkskul = Ekstrakurikuler::count();

        // Data ekskul untuk modal/filter
        $ekskul = Ekstrakurikuler::orderBy('nama_ekstrakurikuler')->get();
    
        return view('pembina.perlombaan.index', compact(
            'perlombaan',
            'totalPerlombaan',
            // 'tahunIni',
            'totalEkskul',
            'ekskul'
        ));
    }
        
    // Tambah perlombaan
    public function store(Request $request)
    {
        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikuler,id',
            'nama_perlombaan'    => 'required|string|max:255',
            'tanggal'            => 'required|date',
            'tingkat'            => 'nullable|string|max:255',
            'tempat'             => 'nullable|string|max:255',
            'tahun_ajaran'       => 'nullable|string|max:10',
            'deskripsi'          => 'nullable|string',
            'foto'               => 'nullable|image|max:2048',
        ]);

        $fotoPath = $request->hasFile('foto') 
            ? $request->file('foto')->store('perlombaan', 'public') 
            : null;

        Perlombaan::create([
            'ekstrakurikuler_id' => $request->ekstrakurikuler_id,
            'nama_perlombaan'    => $request->nama_perlombaan,
            'tanggal'            => $request->tanggal,
            'tingkat'            => $request->tingkat,
            'tempat'             => $request->tempat,
            'tahun_ajaran'       => $request->tahun_ajaran,
            'deskripsi'          => $request->deskripsi,
            'foto'               => $fotoPath,
        ]);

        return back()->with('success', 'Perlombaan berhasil ditambahkan');
    }

    // Update perlombaan
    public function update(Request $request, $id)
    {
        $perlombaan = Perlombaan::findOrFail($id);

        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikuler,id',
            'nama_perlombaan'    => 'required|string|max:255',
            'tanggal'            => 'required|date',
            'tingkat'            => 'nullable|string|max:255',
            'tempat'             => 'nullable|string|max:255',
            'tahun_ajaran'       => 'nullable|string|max:10',
            'deskripsi'          => 'nullable|string',
            'foto'               => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($perlombaan->foto && Storage::disk('public')->exists($perlombaan->foto)) {
                Storage::disk('public')->delete($perlombaan->foto);
            }
            $perlombaan->foto = $request->file('foto')->store('perlombaan', 'public');
        }

        $perlombaan->update([
            'ekstrakurikuler_id' => $request->ekstrakurikuler_id,
            'nama_perlombaan'    => $request->nama_perlombaan,
            'tanggal'            => $request->tanggal,
            'tingkat'            => $request->tingkat,
            'tempat'             => $request->tempat,
            'tahun_ajaran'       => $request->tahun_ajaran,
            'deskripsi'          => $request->deskripsi,
        ]);

        return back()->with('success', 'Perlombaan berhasil diupdate');
    }

    // Hapus perlombaan
    public function destroy($id)
    {
        $perlombaan = Perlombaan::findOrFail($id);

        if ($perlombaan->foto && Storage::disk('public')->exists($perlombaan->foto)) {
            Storage::disk('public')->delete($perlombaan->foto);
        }

        $perlombaan->delete();

        return back()->with('success', 'Perlombaan berhasil dihapus');
    }
}