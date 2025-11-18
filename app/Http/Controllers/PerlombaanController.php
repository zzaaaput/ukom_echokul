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

        $perlombaan = Perlombaan::with('ekstrakurikuler')
            ->when($search, function($q) use ($search) {
                $q->where('nama_perlombaan', 'like', "%$search%")
                  ->orWhere('tingkat', 'like', "%$search%")
                  ->orWhere('tempat', 'like', "%$search%")
                  ->orWhere('tahun_ajaran', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // WAJIB — Dropdown ambil semua ekskul
        $ekskul = Ekstrakurikuler::orderBy('nama_ekstrakurikuler', 'asc')->get();

        return view('pembina.perlombaan.index', compact('perlombaan', 'ekskul'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ekstrakurikuler' => 'required',
            'nama_perlombaan'    => 'required',
            'tanggal'            => 'required|date',
            'tingkat'            => 'required',
            'tempat'             => 'required',
            'tahun_ajaran'       => 'required',
            'deskripsi'          => 'nullable',
            'foto'               => 'nullable|image|max:2048',
        ]);

        $fotoPath = $request->hasFile('foto')
            ? $request->file('foto')->store('perlombaan', 'public')
            : null;

        Perlombaan::create([
            'nama_ekstrakurikuler' => $request->ekstrakurikuler_id,
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

    public function update(Request $request, $id)
    {
        $perlombaan = Perlombaan::findOrFail($id);

        $request->validate([
            'nama_ekstrakurikuler' => 'required',
            'nama_perlombaan'    => 'required',
            'tanggal'            => 'required|date',
            'tingkat'            => 'required',
            'tempat'             => 'required',
            'tahun_ajaran'       => 'required',
            'deskripsi'          => 'nullable',
            'foto'               => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($perlombaan->foto && Storage::disk('public')->exists($perlombaan->foto)) {
                Storage::disk('public')->delete($perlombaan->foto);
            }

            $perlombaan->foto = $request->file('foto')->store('perlombaan', 'public');
        }

        $perlombaan->update([
            'nama_ekstrakurikuler' => $request->ekstrakurikuler_id,
            'nama_perlombaan'    => $request->nama_perlombaan,
            'tanggal'            => $request->tanggal,
            'tingkat'            => $request->tingkat,
            'tempat'             => $request->tempat,
            'tahun_ajaran'       => $request->tahun_ajaran,
            'deskripsi'          => $request->deskripsi,
        ]);

        return back()->with('success', 'Perlombaan berhasil diupdate');
    }

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
